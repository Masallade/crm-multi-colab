<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenRouter API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for OpenRouter API integration with AHHAM AI Assistant
    |
    */

    'api_key' => env('OPENROUTER_API_KEY', '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'),
    
    'model' => env('OPENROUTER_MODEL', 'deepseek/deepseek-chat-v3.1:free'),
    
    'base_url' => env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1'),
    
    'timeout' => env('OPENROUTER_TIMEOUT', 30),
    
    'max_tokens' => env('OPENROUTER_MAX_TOKENS', 2000),
    
    'temperature' => env('OPENROUTER_TEMPERATURE', 0.7),
    
    'system_prompt' => "You are AHHAM, an AI assistant for a CRM system. You help users with:
    - Employee management and HR tasks
    - Project tracking and task management
    - Reports and analytics
    - General CRM questions
    - System navigation and features
    
    Be helpful, professional, and provide specific guidance related to CRM operations. Keep responses concise but informative.",
];
