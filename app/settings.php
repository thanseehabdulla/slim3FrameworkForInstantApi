<?php

return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'PoweredBy' => 'PR2StudioAPI',

        // database settings
        'pdo' => [
            'dsn' => 'mysql:host=localhost:3307;dbname=slim_three;charset=utf8',
            'username' => 'root',
            'password' => 'namoideen',
        ],
        
        // api rate limiter settings
        'api_rate_limiter' => [
            'requests' => '200',
            'inmins' => '60',
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__.'/../log/app.log',
        ],
    ],
];
