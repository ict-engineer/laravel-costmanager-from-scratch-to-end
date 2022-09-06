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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'twilio' => [
        'sid' => env('TWILIO_AUTH_SID'),
        'token' => env('TWILIO_AUTH_TOKEN'),
        'whatsapp_from' => env('TWILIO_WHATSAPP_FROM')
    ],

    'google' => [
        'client_id' => '1053435616172-qlppv162pp2dgk5iucc6a5arnumf3sld.apps.googleusercontent.com',
        'client_secret' => 'LZAOGU7dGtrVqB87sowlEkzk',
        'redirect' => 'https://www.thequotebox.app/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '317957316165006',
        'client_secret' => 'fcecb5fa127732d6a407682a248c0c14',
        'redirect' => 'https://www.thequotebox.app/auth/facebook/callback',
    ],
];
