<?php

return [
    'database' => [
        'mysql' => [
            'host' => 'localhost',
            'database' => 'servex_db',
            'username' => 'root',
            'password' => '',
            'options' => []
        ],
        'postgresql' => [
            'host' => 'localhost',
            'database' => 'servex_db',
            'username' => 'root',
            'password' => '',
            'options' => []
        ],
        'mongodb' => [
            'host' => 'localhost',
            'database' => 'servex_db',
            'username' => 'root',
            'password' => '',
            'options' => []
        ]
    ]
    ,
    'cache' => [
        'path' => __DIR__ . '/../cache'
    ],
    'auth' => [
        'secret_key' => 'your_secret_key_here',
        'token_ttl' => 3600 // Token time-to-live in seconds
    ]
];
