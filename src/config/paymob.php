<?php


return [

    /*
    |--------------------------------------------------------------------------
    | PayMob Default Order Model
    |--------------------------------------------------------------------------
    |
    | This option defines the default Order model.
    |
    */

    'order' => [
        'model' => 'App\Order'
    ],

    /*
    |--------------------------------------------------------------------------
    | PayMob Api Key
    |--------------------------------------------------------------------------
    |
    | This is your PayMob api key to make auth request.
    |
    */

    'api_key' => '',

    /*
    |--------------------------------------------------------------------------
    | PayMob integration ids and iframe id
    |--------------------------------------------------------------------------
    |
    | This is your PayMob integration ids and iframe id.
    |
    */


    'integration_id_credit' => '',
    'integration_id_cash' => '',
    'integration_id_aman' => '',
    'integration_id_wallet' => '',
    'iframe_id' => '',
];
