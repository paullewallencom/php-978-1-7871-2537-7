<?php

namespace App;

class Dummy
{
    public static $availableLocales = [
        'en_GB',
        'en_US',
        'es_ES',
        'gl_ES'
    ];

    public static function getConfigArray()
    {
        return [
            'debug'   => true,
            'storage' => [
                'host' => 'localhost',
                'port' => 5432,
                'user' => 'my-user',
                'pass' => 'my-secret-password'
            ]
        ];
    }

    public static function getRandomCode()
    {
        return 'CODE-123A';
    }
}