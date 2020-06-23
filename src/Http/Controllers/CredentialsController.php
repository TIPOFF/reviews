<?php

namespace DrewRoberts\Google\Http\Controllers;

use DrewRoberts\GoogleData\GoogleFacade;

class ChuckNorrisController
{
    public function __invoke()
    {
        return view('googledata::grant-access', [
            
        ]);
    }
}