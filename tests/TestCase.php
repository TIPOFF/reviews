<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests;

use Laravel\Nova\NovaCoreServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tipoff\Reviews\ReviewsServiceProvider;
use Tipoff\Reviews\Tests\Support\Models\User;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\Reviews\Tests\Support\Providers\NovaTestbenchServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing'])->run();

        // Create stub tables for stub models to satisfy possible FK dependencies
        foreach (config('tipoff.model_class') as $class) {
            if (method_exists($class, 'createTable')) {
                $class::createTable();
            }
        }
    }

    protected function getPackageProviders($app)
    {
        return [
            NovaCoreServiceProvider::class,
            NovaTestbenchServiceProvider::class,
            SupportServiceProvider::class,
            ReviewsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('tipoff.model_class.user', User::class);

        // Create stub tables to satisfy FK dependencies
        foreach (config('tipoff.model_class') as $modelClass) {
            createModelStub($modelClass);
        }

        // Create nova resource stubs for anything not already defined
        foreach (config('tipoff.nova_class') as $alias => $novaClass) {
            if ($modelClass = config('tipoff.model_class.'.$alias)) {
                createNovaResourceStub($novaClass, $modelClass);
            }
        }
    }
}
