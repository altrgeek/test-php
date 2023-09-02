<?php

return [
    /*
    * ------------------------------------------------------------------------
    * Stripe Api Keys
    * ------------------------------------------------------------------------
    */
    'keys' => [
        'public_key' => env('STRIPE_PUBLIC_KEY'),
        'secret_key' => env('STRIPE_PRIVATE_KEY'),
    ],

];
