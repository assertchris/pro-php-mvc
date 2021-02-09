<?php

return [
    'default' => 'stream',
    'stream' => [
        'type' => 'stream',
        'path' => __DIR__ . '/../storage/app.log',
        'name' => 'App',
        'minimum' => \Monolog\Logger::DEBUG,
    ],
];
