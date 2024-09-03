<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'client' => [
            'driver' => 'session',
            'provider' => 'clients',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'clients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Client::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'admins',
            'expire' => 60,
            'throttle' => 60,
        ],
        'clients' => [
            'provider' => 'clients',
            'table' => 'clients',
            'expire' => 60,
            'throttle' => 60,
        ],



    ],

    'password_timeout' => 10800,


];
