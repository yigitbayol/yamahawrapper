<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Yamaha Rest API Username
    |--------------------------------------------------------------------------
    |
    | Username given by Yamaha
    |
    */
    "username" => env('YAMAHA_USERNAME'),
    /*
    |--------------------------------------------------------------------------
    | Yamaha Rest API Password
    |--------------------------------------------------------------------------
    |
    | Password given by Yamaha
    |
    */
    "password" => env('YAMAHA_PASSWORD'),
    /*
    |--------------------------------------------------------------------------
    | Yamaha Rest API Grant Type
    |--------------------------------------------------------------------------
    |
    | Grant Type given by Yamaha
    |
    */
    "grant_type" => env('YAMAHA_GRANT_TYPE', 'password'),
    /*
    |--------------------------------------------------------------------------
    | Yamaha Rest API URL
    |--------------------------------------------------------------------------
    |
    | URL for fetching data from Yamaha
    |
    */
    "url" => env('YAMAHA_URL', 'https://dms-tr.yamnet.com/ymtr_webapi/'),
];
