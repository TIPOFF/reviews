<?php

namespace DrewRoberts\Reporting;

//use DrewRoberts\Reporting\Console\Commands\PullInsights;
//use DrewRoberts\Reporting\Console\Commands\PullReviews;
//use DrewRoberts\Reporting\Console\Commands\SnapshotCompetitors;
//use DrewRoberts\Reporting\Console\Commands\SyncLocations;
use DrewRoberts\Reporting\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class ReportingServiceProvider
 *
 * @package DrewRoberts\Reporting
 */
class ReportingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/reporting.php' => config_path('reporting.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/reporting'),
            ], 'views');

//            $this->commands([
//                PullInsights::class,
//                PullReviews::class,
//                SnapshotCompetitors::class,
//                SyncLocations::class,
//            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'reporting');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Allows for route registration with Route::reporting();
        Route::macro('reporting', function($prefix = 'reporting') {
            Route::group(['prefix' => $prefix], function() {
                Route::get('grant-access', [AccessController::class, 'show']);
            });
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/reporting.php', 'reporting');
    }
}
