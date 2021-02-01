<?php

namespace Tipoff\Reviews;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Reviews\Commands\ReviewsCommand;

class ReviewsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('reviews')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_reviews_table')
            ->hasCommand(ReviewsCommand::class);
    }
}
