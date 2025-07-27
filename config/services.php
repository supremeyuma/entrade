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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'fcsapi' => [
        'key' => env('FCSAPI_KEY'),
    ],

    'twelvedata' => [
        'key' => env('TWELVE_DATA_API_KEY'),
    ],
    'finnhub' => [
        'key' => env('FINNHUB_API_KEY'),
    ],
    'tokenmetrics' => [
        'key' => env('TOKENMETRICS_API_KEY'),
    ],

    'alpha_vantage' => [
        'key' => env('ALPHA_VANTAGE_API_KEY'),
    ],

    'polygon' => [
        'key' => env('POLYGON_API_KEY'),
        'base_url' => env('POLYGON_BASE_URL', 'https://api.polygon.io'),
    ],


];
