<?php

return [
    'roles' => [
        'available' => [
            'super_admin',
            'admin',
            'provider',
            'client',
            'user'
        ],
        'default' => 'user'
    ],
    'admins' => [
        'segments' => [
            'enterprise' => 'Enterprise (Wellness programs)',
            'eap' => 'Employees assistance program (EAP)',
            'hospital' => 'Hospital',
            'clinic' => 'Clinic',
            'nfp' => 'Not-for-profit',
            'private' => 'Private Practice',
            'others' => 'Others'
        ]
    ],
    'storage' => [
        'limits' => [
            'image' => 1024 * 2,
            'video' => 1024 * 30,
            'document' => 1024 * 100,
            'audio' => 1024 * 1
        ],
        'types' => [
            'video' => ['3gp', 'mp4', 'mpeg', 'mpg', 'web', 'avi'],
            'audio' => ['mp3', 'ogg', 'm4a', 'mp4a', 'weba', 'wav'],
            'document' => ['*'],
        ],
    ],
    'meeting' => [
        'cogni' => [
            'url' => env('MEETING_APP_URL', '#'),
            'agora' => [
                'app_id' => env('AGORA_APP_ID', ''),
                'certificate' => env('AGORA_CERT_ID', '')
            ]
        ],
        'zoom' => [
            'url' => env('ZOOM_MEET_URL', '#')
        ],
        'google' => [
            'url' => env('GOOGLE_MEET_URL', '#')
        ]
    ],
    'api' => [
        'API_TOKEN_AI' => env('API_TOKEN_AI', '')
    ],
    'super_admin_support' => [
        'check' =>false,
        'password' => env('SUPPORT_PASSWORD', 'cogni2022ver2')
    ]
];
