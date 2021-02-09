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
use Tipoff\Vouchers\Nova\Voucher;
use Tipoff\Vouchers\Nova\VoucherType;

class NovaTestbenchServiceProvider extends NovaApplicationServiceProvider
{
    protected function resources()
    {
        Nova::resources(array_merge(config('tipoff.nova_class'), [
            Competitor::class,
            Insight::class,
            Review::class,
            Snapshot::class,
        ]));
    }

    protected function routes()
    {
        Nova::routes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }
}
