<?php

namespace DrewRoberts\Google;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use DrewRoberts\Google\\Http\Controllers\CredentialsController;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'google');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/google'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../config/google.php' => config_path('google.php'),
        ]);

        Route::get('grant-access', CredentialsController::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/google.php', 'google');

    }

    protected function guardAgainstInvalidConfiguration(array $googleConfig = null)
    {

    }
}