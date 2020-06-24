<?php

namespace DrewRoberts\Reporting;

use Illuminate\Support\Facades\Facade;

/**
 * Class ReportingFacade
 *
 * @package DrewRoberts\Reporting
 */
class ReportingFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'reporting';
    }
}
