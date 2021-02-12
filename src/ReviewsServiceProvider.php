<?php

declare(strict_types=1);

namespace Tipoff\Reviews;

use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Reviews\Models\Competitor;
use Tipoff\Reviews\Models\Insight;
use Tipoff\Reviews\Models\Review;
use Tipoff\Reviews\Models\Snapshot;
use Tipoff\Reviews\Policies\CompetitorPolicy;
use Tipoff\Reviews\Policies\InsightPolicy;
use Tipoff\Reviews\Policies\ReviewPolicy;
use Tipoff\Reviews\Policies\SnapshotPolicy;

class ReviewsServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        parent::boot();
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('reviews')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        foreach ([
            Competitor::class => CompetitorPolicy::class,
            Insight::class => InsightPolicy::class,
            Review::class => ReviewPolicy::class,
            Snapshot::class => SnapshotPolicy::class,
        ] as $key => $policy) {
            Gate::policy($key, $policy);
        }
    }
}
