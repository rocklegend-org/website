<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => User::class,
        'key'    => '',
        'secret' => '',
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID', '1510352382540804'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', 'a3fac179c66197ab489cf0e9a717a3c6'),
        'scope'     => env('FACEBOOK_SCOPE', array('email')),
        'redirect'  => env('APP_URL').'/login/facebook/process'
    ],    

];
