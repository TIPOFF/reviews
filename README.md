# Laravel Wrapper for Google Api Client

This is an opinionated Laravel wrapper for [Google API PHP Client](https://github.com/googleapis/google-api-php-client) with a different implementation than [Pulkit Jalan's package](https://github.com/pulkitjalan/google-apiclient).

This package allows multiple users to grant access to their data via the Google API. These credentials are stored in a database table instead of a json file in the directory. It can also be used with just one credential, but the Laravel default User model with [Authentication](https://laravel.com/docs/authentication) is needed.

The credentials have access tokens and refresh tokens that are updated when needed so they never expire and can be used by the application to gather data or act on behalf of the user through Google's API. The user has the ability to revoke access in their Google account.

## Installation

This package can be installed through Composer.

``` bash
composer require drewroberts/laravel-google-api-client
```

You can publish the config file of this package with this command:

``` bash
php artisan vendor:publish --provider="DrewRoberts\Google\GoogleServiceProvider"
```

The following config file will be published in `config/google.php`

```php
return [

    /*
     * Here you may define the "scopes" that your application will request
     * from the users and need for the data you will access throuh the API.
     * For more information, see docs for google-api-php-client.
     */
    'scopes' => [
        'https://www.googleapis.com/auth/business.manage',
    ],
];
```
