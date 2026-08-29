<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Chatbot Provider
    |--------------------------------------------------------------------------
    |
    | Supported: "gemini", "openai", "groq", "openrouter"
    |
    */
    'provider' => env('CHATBOT_PROVIDER', 'gemini'),

    /*
    |--------------------------------------------------------------------------
    | Google Gemini AI Settings
    |--------------------------------------------------------------------------
    */
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-3.5-flash-lite'),
        'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
    ],

    /*
    |--------------------------------------------------------------------------
    | OpenAI / Groq / OpenRouter Settings
    |--------------------------------------------------------------------------
    */
    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
        'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Chatbot Personality & Configuration
    |--------------------------------------------------------------------------
    */
    'system_prompt_prefix' => env('CHATBOT_SYSTEM_PROMPT', 'Kamu adalah asisten virtual cerdas dan ramah untuk website sekolah.'),
    'max_tokens' => (int) env('CHATBOT_MAX_TOKENS', 800),
    'temperature' => (float) env('CHATBOT_TEMPERATURE', 0.7),
];
