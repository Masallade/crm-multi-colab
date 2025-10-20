<?php

namespace App\Http\Controllers;

use App\Services\DatabaseContextService;
use App\Services\AhhamContextService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AhhamController extends Controller
{
    /**
     * Display the AHHAM dashboard
     */
    public function index()
    {
        return view('ahham.index');
    }

    /**
     * Handle chat messages with OpenRouter API
     */
    public function chat(Request $request)
    {
        $message = $request->input('message');
        $user = Auth::user();
        
        // Debug logging
        Log::info('AHHAM Chat Request - Message: ' . $message);
        Log::info('AHHAM Chat Request - User: ' . ($user ? $user->id : 'Not authenticated'));
        
        // Get conversation history from session
        $conversationHistory = session('ahham_conversation', []);
        
        // Add user message to history
        $conversationHistory[] = [
            'role' => 'user',
            'content' => $message,
            'timestamp' => now()
        ];
        
        try {
            // Get OpenRouter API configuration
            $apiKey = config('openrouter.api_key');
            $model = config('openrouter.model');
            $baseUrl = config('openrouter.base_url');
            $systemPrompt = AhhamContextService::buildSystemPrompt();
            $maxTokens = config('openrouter.max_tokens');
            $temperature = config('openrouter.temperature');
            $timeout = config('openrouter.timeout');
            
            // Debug logging
            Log::info('AHHAM API Request - Model: ' . $model);
            Log::info('AHHAM API Request - Base URL: ' . $baseUrl);
            Log::info('AHHAM API Request - Message: ' . $message);
            Log::info('AHHAM API Request - API Key: ' . (strlen($apiKey) > 10 ? substr($apiKey, 0, 10) . '...' : 'Invalid'));
            
            // Build messages array with conversation history
            $messages = [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ]
            ];
            
            // Add conversation history (last 10 messages to avoid token limits)
            $recentHistory = array_slice($conversationHistory, -10);
            foreach ($recentHistory as $historyMessage) {
                $messages[] = [
                    'role' => $historyMessage['role'],
                    'content' => $historyMessage['content']
                ];
            }
            
            // Make API call to OpenRouter
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json'
            ])->timeout($timeout)->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => $messages
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                $aiResponse = $data['choices'][0]['message']['content'] ?? 'I apologize, but I couldn\'t generate a response at this time.';
                
                Log::info('AHHAM API Success: ' . $aiResponse);
                
                // Check if response was truncated
                if (strpos($aiResponse, '

') !== false) {
                    Log::warning('AHHAM Response was truncated!');
                    // Try to extract what we can from the truncated response
                    $aiResponse = preg_replace('/

.*$/', '', $aiResponse);
                }
                
                // Check if the response contains a SQL query (multiple formats)
                $sqlQuery = null;
                
                // Format 1: QUERY: [sql]
                if (preg_match('/QUERY:\s*(.+)/i', $aiResponse, $matches)) {
                    $sqlQuery = trim($matches[1]);
                }
                // Format 2: ```sql [sql] ```
                elseif (preg_match('/```sql\s*(.+?)\s*```/is', $aiResponse, $matches)) {
                    $sqlQuery = trim($matches[1]);
                }
                // Format 3: ``` [sql] ```
                elseif (preg_match('/```\s*(SELECT.+?)\s*```/is', $aiResponse, $matches)) {
                    $sqlQuery = trim($matches[1]);
                }
                
                // Clean up any corrupted characters or truncation markers
                if ($sqlQuery) {
                    // Remove any truncation markers or corrupted characters
                    $sqlQuery = preg_replace('/<\|.*?\|>/', '', $sqlQuery);
                    $sqlQuery = preg_replace('/<\|redacted.*/', '', $sqlQuery);
                    $sqlQuery = trim($sqlQuery);
                    
                    // Ensure it ends with semicolon if it doesn't already
                    if (!preg_match('/;\s*$/', $sqlQuery)) {
                        $sqlQuery .= ';';
                    }
                }
                
                // Fallback: If no SQL query detected but the message seems like a database query request
                if (!$sqlQuery && (
                    stripos($message, 'staff id') !== false || 
                    stripos($message, 'employee name') !== false ||
                    stripos($message, 'attendance') !== false ||
                    stripos($message, 'employee') !== false
                )) {
                    // Try to generate a simple query based on the message
                    if (preg_match('/staff\s+id\s+is\s+([A-Z0-9-]+)/i', $message, $matches)) {
                        $staffId = $matches[1];
                        $sqlQuery = "SELECT first_name, last_name, staff_id FROM employees WHERE staff_id = '{$staffId}'";
                        Log::info('AHHAM Fallback SQL Query: ' . $sqlQuery);
                    }
                }
                
                if ($sqlQuery) {
                    Log::info('AHHAM SQL Query (cleaned): ' . $sqlQuery);
                    Log::info('AHHAM Original Response: ' . $aiResponse);
                    
                    // Execute the SQL query
                    $queryResult = DatabaseContextService::executeQuery($sqlQuery);
                    
                    if ($queryResult['success']) {
                        // Send the query results back to AI for formatting
                        $contextMessage = "Query executed successfully. Here are the results:\n\n" . 
                                        "Number of records: " . $queryResult['count'] . "\n\n" .
                                        "Data: " . json_encode($queryResult['data'], JSON_PRETTY_PRINT) . "\n\n" .
                                        "Please format this data in a user-friendly way and provide insights.";
                        
                        // Get AI to format the results
                        $formatResponse = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $apiKey,
                            'Content-Type' => 'application/json'
                        ])->timeout($timeout)->post($baseUrl . '/chat/completions', [
                            'model' => $model,
                            'messages' => [
                                [
                                    'role' => 'system',
                                    'content' => 'You are AHHAM. Format the database query results in a user-friendly, readable format. Provide insights and analysis based on the data.'
                                ],
                                [
                                    'role' => 'user',
                                    'content' => $contextMessage
                                ]
                            ]
                        ]);
                        
                        if ($formatResponse->successful()) {
                            $formatData = $formatResponse->json();
                            $formattedResponse = $formatData['choices'][0]['message']['content'] ?? $aiResponse;
                        } else {
                            $formattedResponse = $aiResponse . "\n\nQuery executed successfully. Found " . $queryResult['count'] . " records.";
                        }
                        
                        // Add AI response to conversation history
                        $conversationHistory[] = [
                            'role' => 'assistant',
                            'content' => $formattedResponse,
                            'timestamp' => now()
                        ];
                        
                        // Save conversation history to session
                        session(['ahham_conversation' => $conversationHistory]);
                        
                        return response()->json([
                            'success' => true,
                            'message' => $formattedResponse,
                            'timestamp' => now()->format('H:i:s'),
                            'user' => $user->first_name . ' ' . $user->last_name,
                            'query_executed' => true,
                            'record_count' => $queryResult['count']
                        ]);
                    } else {
                        $errorResponse = $aiResponse . "\n\n❌ Query execution failed: " . $queryResult['error'];
                        
                        // Add AI response to conversation history
                        $conversationHistory[] = [
                            'role' => 'assistant',
                            'content' => $errorResponse,
                            'timestamp' => now()
                        ];
                        
                        // Save conversation history to session
                        session(['ahham_conversation' => $conversationHistory]);
                        
                        return response()->json([
                            'success' => true,
                            'message' => $errorResponse,
                            'timestamp' => now()->format('H:i:s'),
                            'user' => $user->first_name . ' ' . $user->last_name
                        ]);
                    }
                }
                
                // Add AI response to conversation history
                $conversationHistory[] = [
                    'role' => 'assistant',
                    'content' => $aiResponse,
                    'timestamp' => now()
                ];
                
                // Save conversation history to session
                session(['ahham_conversation' => $conversationHistory]);
                
                return response()->json([
                    'success' => true,
                    'message' => $aiResponse,
                    'timestamp' => now()->format('H:i:s'),
                    'user' => $user->first_name . ' ' . $user->last_name
                ]);
            } else {
                Log::error('OpenRouter API Error - Status: ' . $response->status());
                Log::error('OpenRouter API Error - Body: ' . $response->body());
                Log::error('OpenRouter API Error - Headers: ' . json_encode($response->headers()));
                Log::error('OpenRouter API Error - Request URL: ' . $baseUrl . '/chat/completions');
                Log::error('OpenRouter API Error - Request Headers: ' . json_encode([
                    'Authorization' => 'Bearer ' . (strlen($apiKey) > 10 ? substr($apiKey, 0, 10) . '...' : 'Invalid'),
                    'Content-Type' => 'application/json',
                    'HTTP-Referer' => request()->getSchemeAndHttpHost(),
                    'X-Title' => 'AHHAM CRM Assistant'
                ]));
                
                // Fallback response if API fails
                $fallbackResponses = [
                    "I'm experiencing some technical difficulties right now. Please try again in a moment.",
                    "I'm having trouble connecting to my AI brain. Let me try to help you with a basic response.",
                    "There seems to be a connection issue. I'm AHHAM, your CRM assistant. How can I help you today?"
                ];
                
                return response()->json([
                    'success' => true,
                    'message' => $fallbackResponses[array_rand($fallbackResponses)],
                    'timestamp' => now()->format('H:i:s'),
                    'user' => $user->first_name . ' ' . $user->last_name
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('AHHAM Chat Error: ' . $e->getMessage());
            
            // Fallback response on exception
            return response()->json([
                'success' => true,
                'message' => "I'm AHHAM, your AI assistant. I'm here to help with your CRM needs. What would you like to know?",
                'timestamp' => now()->format('H:i:s'),
                'user' => $user->first_name . ' ' . $user->last_name
            ]);
        }
    }

    /**
     * Get chat history
     */
    public function getChatHistory()
    {
        // This would typically fetch from database
        // For now, return sample data
        return response()->json([
            'success' => true,
            'messages' => [
                [
                    'id' => 1,
                    'message' => 'Welcome to AHHAM! I\'m your AI assistant.',
                    'type' => 'bot',
                    'timestamp' => now()->subMinutes(5)->format('H:i:s')
                ]
            ]
        ]);
    }

    /**
     * Get database context for AHHAM
     */
    public function getDatabaseContext()
    {
        try {
            $context = DatabaseContextService::getDatabaseContext();
            return response()->json([
                'success' => true,
                'context' => $context
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting database context: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to get database context'
            ]);
        }
    }

    /**
     * Clear chat history
     */
    public function clearChat()
    {
        // Clear conversation history from session
        session()->forget('ahham_conversation');
        
        return response()->json([
            'success' => true,
            'message' => 'Chat history cleared successfully'
        ]);
    }

    /**
     * Test API connection
     */
    public function testApi()
    {
        try {
            $apiKey = config('openrouter.api_key');
            $model = config('openrouter.model');
            $baseUrl = config('openrouter.base_url');
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => request()->getSchemeAndHttpHost(),
                'X-Title' => 'AHHAM CRM Assistant'
            ])->timeout(30)->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => 'Hello, this is a test message.'
                    ]
                ],
                'max_tokens' => 100,
                'temperature' => 0.7,
                'stream' => false
            ]);
            
            return response()->json([
                'success' => $response->successful(),
                'status' => $response->status(),
                'body' => $response->body(),
                'headers' => $response->headers(),
                'config' => [
                    'api_key' => substr($apiKey, 0, 20) . '...',
                    'model' => $model,
                    'base_url' => $baseUrl
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'config' => [
                    'api_key' => substr(config('openrouter.api_key'), 0, 20) . '...',
                    'model' => config('openrouter.model'),
                    'base_url' => config('openrouter.base_url')
                ]
            ]);
        }
    }
}
