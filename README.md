# Laravel Wrapper for Google Api Client

This is an opinionated Laravel wrapper for [Google API PHP Client](https://github.com/googleapis/google-api-php-client) with a different implementation than [Pulkit Jalan's package](https://github.com/pulkitjalan/google-apiclient).

This package allows multiple users to grant access to their data via the Google API. These credentials are stored in a database table instead of a json file in the directory. It can also be used with just one credential, but the Laravel default User model with [Authentication](https://laravel.com/docs/authentication) is needed.
