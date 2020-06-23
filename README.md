# Laravel Location Reporting

This package is an implementation for gathering data for location-based reporting through Google API's for Google My Business (GMB), Google Places, and Google Analytics. It stores both Reviews and Insights from GMB locations. It also allows Competitors of those locations to be stored in a database table and collects snapshots of total reviews and ratings of those competitors from Google Places. For websites with location/market based URL structures it stores Google Analytics data as well.

This package includes an opinionated Laravel wrapper for the [Google API PHP Client](https://github.com/googleapis/google-api-php-client) with a different implementation than [Pulkit Jalan's package](https://github.com/pulkitjalan/google-apiclient). These credentials are stored in a database table instead of a json file in the directory. It uses the Laravel default User model with [Authentication](https://laravel.com/docs/authentication). The credentials have access tokens and refresh tokens that are updated when needed so they never expire and can be used by the application to gather data or act on behalf of the user through Google's API. The user has the ability to revoke access in their Google account.

In addition to the user granted permission token, the package also uses an application token for Google Places which is added to the .env file.

## Installation

This package can be installed through Composer.

``` bash
composer require drewroberts/reporting
```

You can publish the config file of this package with this command:

``` bash
php artisan vendor:publish --provider="DrewRoberts\GoogleData\ReportingServiceProvider"
```

The following config file will be published in `config/googledata.php`

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
