<?php

return [
    'credentials' => [
        'super_admin' => [
            'email' => env('SUPER_ADMIN_EMAIL', 'admin@cognimeet.com'),
            'password' => env('SUPER_ADMIN_PASSWORD', 'password'),
        ]
    ]
];
