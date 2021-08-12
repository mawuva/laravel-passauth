<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Users feature settings
    |--------------------------------------------------------------------------
    */

    'user' => [
        'model'             => App\Models\User::class,
        'name'              => 'User',
        'resource_name'     => 'user',

        'table'     => [
            'name'          => env('PASSAUTH_USERS_DATABASE_TABLE', 'users'),
            'primary_key'   => env('PASSAUTH_USERS_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password history config
    |--------------------------------------------------------------------------
    */
    'password_history' => [
        'enable'            => true,
        'checker'           => false,
        'number_to_check'   => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Required identifiants
    |--------------------------------------------------------------------------
    */

    'required_identifiants' => [
        'email'                 => true,
        'phone_number'          => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Bunch of features to enable or disable.
    |--------------------------------------------------------------------------
    */

    'enable' => [
        'email_verification' => false,
        'proper_names' => false,
        'agree_with_policy_and_terms_data' => true,
        'last_login_data' => true,
    ],

    'agree_with_policy_and_terms_column' => [
        'name' => 'has_agreed_with_policy_and_terms_at',
        'type' => 'timestamp'
    ],

    'last_login_column' => [
        'name' => 'last_login_at',
        'type' => 'timestamp'
    ],
];