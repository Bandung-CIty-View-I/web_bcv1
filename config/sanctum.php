<?php

use Laravel\Sanctum\Sanctum;

return [



'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
    '%s%s',
    'localhost',
    env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
))),


    'guard' => ['web'],


    'expiration' => env('SANCTUM_TOKEN_EXPIRATION_MINUTES', '60'),


    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),


    'middleware' => [
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    ],

];
