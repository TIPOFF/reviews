<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Support\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Tipoff\Reviews\Nova\Competitor;
use Tipoff\Reviews\Nova\Insight;
use Tipoff\Reviews\Nova\Review;
use Tipoff\Reviews\Nova\Snapshot;
use Tipoff\TestSupport\Providers\BaseNovaPackageServiceProvider;

class NovaTestbenchServiceProvider extends BaseNovaPackageServiceProvider
{
    public static array $packageResources = [
        Competitor::class,
        Insight::class,
        Review::class,
        Snapshot::class,
    ];
}
