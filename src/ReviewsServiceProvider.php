<?php

declare(strict_types=1);

namespace Tipoff\Reviews;

use Tipoff\Reviews\Commands\PullInsights;
use Tipoff\Reviews\Commands\PullReviews;
use Tipoff\Reviews\Commands\SendReviewMonthEmail;
use Tipoff\Reviews\Commands\SendReviewWeekendEmail;
use Tipoff\Reviews\Commands\SendSnapshotMonthEmails;
use Tipoff\Reviews\Commands\SendSnapshotTopEmail;
use Tipoff\Reviews\Commands\SendSnapshotWeekEmails;
use Tipoff\Reviews\Models\Competitor;
use Tipoff\Reviews\Models\Insight;
use Tipoff\Reviews\Models\Review;
use Tipoff\Reviews\Models\Snapshot;
use Tipoff\Reviews\Policies\CompetitorPolicy;
use Tipoff\Reviews\Policies\InsightPolicy;
use Tipoff\Reviews\Policies\ReviewPolicy;
use Tipoff\Reviews\Policies\SnapshotPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

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
            ->hasCommands([
                PullInsights::class,
                PullReviews::class,
                SendReviewMonthEmail::class,
                SendReviewWeekendEmail::class,
                SendSnapshotMonthEmails::class,
                SendSnapshotTopEmail::class,
                SendSnapshotWeekEmails::class,
            ])
            ->hasNovaResources([
                \Tipoff\Reviews\Nova\Competitor::class,
                \Tipoff\Reviews\Nova\Insight::class,
                \Tipoff\Reviews\Nova\Review::class,
                \Tipoff\Reviews\Nova\Snapshot::class,
            ])
            ->name('reviews')
            ->hasViews()
            ->hasConfigFile();
    }
}
