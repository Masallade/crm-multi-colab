<?php

namespace App\Services;

class AhhamContextService
{
    /**
     * Get database context from JSON files
     */
    public static function getDatabaseContext()
    {
        $schemaPath = app_path('Data/AhhamContext/database_schema.json');
        $queriesPath = app_path('Data/AhhamContext/sample_queries.json');
        $examplesPath = app_path('Data/AhhamContext/few_shot_examples.json');
        
        $context = [];
        
        if (file_exists($schemaPath)) {
            $context['schema'] = json_decode(file_get_contents($schemaPath), true);
        }
        
        if (file_exists($queriesPath)) {
            $context['sample_queries'] = json_decode(file_get_contents($queriesPath), true);
        }
        
        if (file_exists($examplesPath)) {
            $context['few_shot_examples'] = json_decode(file_get_contents($examplesPath), true);
        }
        
        return $context;
    }
    
    /**
     * Build the system prompt for AHHAM
     */
    public static function buildSystemPrompt()
    {
        $context = self::getDatabaseContext();
        
        $prompt = "You are AHHAM, an intelligent AI assistant for a CRM system. You have access to the database and can execute SQL queries to help users with HR and administrative tasks.\n\n";
        
        // Add database schema
        if (isset($context['schema'])) {
            $prompt .= "DATABASE SCHEMA:\n";
            $prompt .= json_encode($context['schema'], JSON_PRETTY_PRINT) . "\n\n";
        }
        
        // Add few-shot examples
        if (isset($context['few_shot_examples']['examples'])) {
            $prompt .= "FEW-SHOT EXAMPLES:\n";
            foreach ($context['few_shot_examples']['examples'] as $example) {
                $prompt .= "User: " . $example['user_query'] . "\n";
                $prompt .= "AI Thought: " . $example['ai_thought'] . "\n";
                $prompt .= "SQL Query: " . $example['sql_query'] . "\n";
                $prompt .= "Expected Result: " . $example['expected_result'] . "\n\n";
            }
        }
        
        // Add sample query patterns
        if (isset($context['sample_queries']['common_patterns'])) {
            $prompt .= "COMMON QUERY PATTERNS:\n";
            foreach ($context['sample_queries']['common_patterns'] as $pattern) {
                $prompt .= "Intent: " . $pattern['intent'] . "\n";
                $prompt .= "Examples: " . implode(', ', $pattern['examples']) . "\n";
                $prompt .= "SQL Template: " . $pattern['sql_template'] . "\n\n";
            }
        }
        
        $prompt .= "INSTRUCTIONS:\n";
        $prompt .= "- Understand the user's request and identify the intent\n";
        $prompt .= "- Generate appropriate SQL query based on the schema and examples\n";
        $prompt .= "- Use proper JOINs to connect related tables\n";
        $prompt .= "- Apply appropriate filters for dates, names, departments, etc.\n";
        $prompt .= "- CRITICAL: ALWAYS respond with EXACTLY this format: QUERY: [your SQL query here]\n";
        $prompt .= "- NEVER show SQL code in markdown blocks or explain the query\n";
        $prompt .= "- NEVER add any text after the SQL query\n";
        $prompt .= "- NEVER truncate or cut off the SQL query\n";
        $prompt .= "- Keep responses SHORT and CONCISE - only the QUERY: line\n";
        $prompt .= "- Do NOT provide explanations, just the SQL query\n";
        $prompt .= "- I will execute the query and return results for formatting\n";
        $prompt .= "- Be helpful, professional, and provide specific guidance\n";
        $prompt .= "- Handle time-based queries (today, yesterday, this week, etc.)\n";
        $prompt .= "- Support employee searches by first name, last name, or staff_id\n";
        $prompt .= "- For staff_id queries, use: SELECT first_name, last_name FROM employees WHERE staff_id = 'staff_id_value'\n";
        $prompt .= "- Remember: Always use QUERY: format, never ```sql``` blocks\n";
        $prompt .= "- Example response: QUERY: SELECT first_name, last_name FROM employees WHERE staff_id = 'BPS-0000999'\n";
        
        return $prompt;
    }
    
    /**
     * Get context for specific intent
     */
    public static function getContextForIntent($intent)
    {
        $context = self::getDatabaseContext();
        
        if (isset($context['sample_queries']['common_patterns'])) {
            foreach ($context['sample_queries']['common_patterns'] as $pattern) {
                if (strtolower($pattern['intent']) === strtolower($intent)) {
                    return $pattern;
                }
            }
        }
        
        return null;
    }
    
    /**
     * Get time modifiers for queries
     */
    public static function getTimeModifiers()
    {
        $context = self::getDatabaseContext();
        
        if (isset($context['sample_queries']['time_functions'])) {
            return $context['sample_queries']['time_functions'];
        }
        
        return [];
    }
}
