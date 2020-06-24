<?php

namespace DrewRoberts\Reporting\Http\Controllers;

/**
 * Class ReportingController
 *
 * @package DrewRoberts\Reporting\Http\Controllers
 */
class ReportingController
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('reporting::grant-access', [

        ]);
    }
}
