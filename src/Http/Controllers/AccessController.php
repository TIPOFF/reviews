<?php

namespace DrewRoberts\Reporting\Http\Controllers;

/**
 * Class ReportingController
 *
 * @package DrewRoberts\Reporting\Http\Controllers
 */
class AccessController
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('reporting::grant-access');
    }
}
