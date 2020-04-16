<?php

namespace DrewRoberts\Google;

use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/google.php' => config_path('google.php'),
        ]);
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