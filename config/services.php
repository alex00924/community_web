<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
     */

    'mailgun'   => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses'       => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe'    => [
        'model'  => App\Models\ShopUser::class,
        // 'key'    => sc_config('card_public_key'),
        // 'secret' => sc_config('card_secret'),
        'key'    => 'pk_test_Rp7yHFgnC7QcOF4mxH5ljKlW00lZraXPXo',
        'secret' => 'sk_test_pJXoqSzUlXM8LCWD8gprTpmB00QdUEp3Hw',
    ],

    'chatkit' => [
        'secret' => env('PUSHER_APP_SECRET'),
        'locator' => env('PUSHER_APP_KEY'),
    ],
];
