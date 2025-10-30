# AHHAM AI Assistant Setup

## Environment Variables Setup

Add the following variables to your `.env` file:

```env
# OpenRouter API Configuration
OPENROUTER_API_KEY=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
OPENROUTER_MODEL=deepseek/deepseek-r1-distill-qwen-2.5-7b-instruct
OPENROUTER_BASE_URL=https://openrouter.ai/api/v1
OPENROUTER_TIMEOUT=30
OPENROUTER_MAX_TOKENS=500
OPENROUTER_TEMPERATURE=0.7
```

## Configuration

The OpenRouter API settings are configured in `/config/openrouter.php`. You can modify:

- **API Key**: Your OpenRouter API key
- **Model**: The AI model to use (currently set to `code_sonoma_sky_alpha`)
- **Base URL**: OpenRouter API endpoint
- **Timeout**: Request timeout in seconds
- **Max Tokens**: Maximum response length
- **Temperature**: Response creativity (0.0 = deterministic, 1.0 = creative)

## Features

✅ **Real AI Integration**: Uses OpenRouter API with your specified model
✅ **CRM Context**: AI understands CRM operations and terminology
✅ **Error Handling**: Graceful fallbacks if API is unavailable
✅ **Logging**: All errors are logged for debugging
✅ **Configurable**: Easy to modify settings via config file

## Usage

1. Add the environment variables to your `.env` file
2. Clear config cache: `php artisan config:clear`
3. Access AHHAM via the sidebar menu
4. Start chatting with your AI assistant!

## Troubleshooting

- Check Laravel logs if responses aren't working
- Verify your API key is correct
- Ensure your OpenRouter account has sufficient credits
- Check network connectivity to OpenRouter API
