<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Public Key
    |--------------------------------------------------------------------------
    */

    'public_key' => env('KLAVIYO_PUBLIC_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Private Key
    |--------------------------------------------------------------------------
    */

    'private_key' => env('KLAVIYO_PRIVATE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | List ID new profiles are subscribed to
    |--------------------------------------------------------------------------
    */
    'list_id' => env('KLAVIYO_LIST_ID', ''),

];