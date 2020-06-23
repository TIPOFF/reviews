<?php

namespace DrewRoberts\GoogleData\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'reporting';
    }
}