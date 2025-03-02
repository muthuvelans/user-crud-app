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
        'api' => [
            'driver' => 'jwt', // ✅ Correct "jwt" driver
            'provider' => 'logins', // ✅ Must match the provider name below
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // ✅ Default Laravel User model
        ],

        'logins' => [ // ✅ Matches the 'api' provider name
            'driver' => 'eloquent',
            'model' => App\Models\Login::class, // ✅ Ensure this model exists
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
