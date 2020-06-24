<?php

namespace DrewRoberts\Reporting\Tests;

use DrewRoberts\Reporting\ReportingServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * Class TestCase
 *
 * @package DrewRoberts\Reporting\Tests
 */
class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/database/factories');
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array|string[]
     */
    protected function getPackageProviders($app)
    {
        return [
            ReportingServiceProvider::class,
        ];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);


        include_once __DIR__.'/../database/migrations/create_reporting_tables.php';
        (new \CreateReportingTables())->up();
    }
}
