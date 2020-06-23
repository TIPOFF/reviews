<?php

namespace DrewRoberts\GoogleData;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use DrewRoberts\Google\\Http\Controllers\CredentialsController;

class ReportingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'googledata');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/googledata'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../config/googledata.php' => config_path('googledata.php'),
        ]);

        Route::get('grant-access', CredentialsController::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/googledata.php', 'googledata');

    }

    protected function guardAgainstInvalidConfiguration(array $googleConfig = null)
    {

    }
}