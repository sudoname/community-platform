<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],

    'schwab' => [
        'api_key' => env('SCHWAB_API_KEY'),
        'api_secret' => env('SCHWAB_API_SECRET'),
        'base_url' => env('SCHWAB_BASE_URL', 'https://api.schwabapi.com/v1'),
        'callback_url' => env('SCHWAB_CALLBACK_URL'),
    ],

];

#SCHWAB_APP_KEY=egi2ATAEJd8Dhs5RLM0SoPfoNkl9j6ht
#SCHWAB_APP_SECRET=k5zcNhvSfAc4NmQG
#SCHWAB_CALLBACK_URL=https://127.0.0.1:5000/callback
#SCHWAB_TOKEN_FILE=schwab_tokens.json
#SCHWAB_ACCOUNT_HASH=47D1E39DBEA0560941C697E005D52D432B9F6DC1E33B95122EE551EF6FBC882E