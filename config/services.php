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

    'telegram_gateway' => [
        'api_id' => env('TELEGRAM_GATEWAY_API_ID'),
        'api_hash' => env('TELEGRAM_GATEWAY_API_HASH'),
        'access_token' => env('TELEGRAM_GATEWAY_ACCESS_TOKEN'),
    ],

    'sms' => [
        'email' => env('SMS_EMAIL', 'ibrohimabdurahmonov2028@gmail.com'),
        'password' => env('SMS_PASSWORD', 'dq62PxevkxY7ckMyaaifEd1fZFNvoGaSXzyRX2gK'),
    ],

];
