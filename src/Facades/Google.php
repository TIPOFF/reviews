<?php

namespace DrewRoberts\Google\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-google-api-client';
    }
}