<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'clientes',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'clientes',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'empleados',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'empleados',
            'hash' => false,
        ],
    ],

    'providers' => [
        'clientes' => [
            'driver' => 'eloquent',
            'model' => App\ClienteAuth::class,
        ],

        'empleados' => [
            'driver' => 'eloquent',
            'model' => App\UsuarioEmpleado::class,
        ],
    ],

    'passwords' => [
        'clientes' => [
            'provider' => 'clientes',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'empleados' => [
            'provider' => 'empleados',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
