<?php

return [
    'default' => 'postmark',
    'postmark' => [
        'type' => 'postmark',
        'token' => env('EMAIL_TOKEN'),
        'from' => [
            'name' => env('EMAIL_FROM_NAME'),
            'email' => env('EMAIL_FROM_EMAIL'),
        ],
    ]
];
