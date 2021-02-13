<?php

declare(strict_types=1);

namespace Tipoff\Reviews;

use Tipoff\Reviews\Models\Competitor;
use Tipoff\Reviews\Models\Insight;
use Tipoff\Reviews\Models\Review;
use Tipoff\Reviews\Models\Snapshot;
use Tipoff\Reviews\Policies\CompetitorPolicy;
use Tipoff\Reviews\Policies\InsightPolicy;
use Tipoff\Reviews\Policies\ReviewPolicy;
use Tipoff\Reviews\Policies\SnapshotPolicy;

class ReviewsServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Competitor::class => CompetitorPolicy::class,
                Insight::class => InsightPolicy::class,
                Review::class => ReviewPolicy::class,
                Snapshot::class => SnapshotPolicy::class,
            ])
            ->name('reviews')
            ->hasConfigFile();
    }
}
