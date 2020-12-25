<?php

return [
    'default'     => 'mysql',
    'migrations' => 'migrations',
    'fetch' => PDO::FETCH_CLASS,
    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'collation' => 'utf8_unicode_ci',
        ]
    ]
];
