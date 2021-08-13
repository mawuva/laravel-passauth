# Passauth - A Bunch of authentication features

This package provide a bunch of authentication features.

## Installation

You can install the package via composer:

```bash
composer require mawuekom/laravel-passauth
```

## Usage

Once install, go to `config/app.php` to add `PassauthServiceProvider` in providers array

 Laravel 5.5 and up Uses package auto discovery feature, no need to edit the `config/app.php` file.

 - #### Service Provider

```php
'providers' => [

    ...

    Mawuekom\Passauth\PassauthServiceProvider::class,

],
```

- #### Publish Assets

```bash
php artisan vendor:publish --tag=passauth
```

Or you can publish config

```bash
php artisan vendor:publish --tag=passauth --config
```

#### Configuration

* You can change connection for models, models path and there is also a handy pretend feature.
* There are many configurable options which have been extended to be able to configured via `.env` file variables.
* Editing the configuration file directly may not needed because of this.
* See config file: [passauth.php](https://github.com/mawuva/laravel-passauth/blob/main/config/passauth.php).


```php
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
```

## The rest is comming soon

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

