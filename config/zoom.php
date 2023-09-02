<?php

return [
        /*
    * ------------------------------------------------------------------------
    * Zoom Api Keys
    * ------------------------------------------------------------------------
    */
    'keys' => [
        'api_key' => env('ZOOM_API_KEY'),
        'api_secret_key' => env('ZOOM_API_SECRET'),
    ],

    "ZOOM_JOIN_SUPER_ADMIN_ADMIN" => "",

    "meeting_url" => env('ZOOM_MEET_URL'),
];
