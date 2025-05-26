<?php

// To be retrieved from database
return [
    'zendesk' => [
        'webhook_secret' => env('ZENDESK_WEBHOOK_SECRET'),
        'api_key' => env('ZENDESK_API_KEY'),
    ],
    'gorgias' => [
        'webhook_secret' => env('GORGIAS_WEBHOOK_SECRET'),
        'api_key' => env('GORGIAS_API_KEY'),
        'base_url' => env('GORGIAS_BASE_URL', 'https://api.gorgias.com/api'),
    ],
];
