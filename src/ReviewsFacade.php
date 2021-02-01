<?php

namespace Tipoff\Reviews;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\Reviews\Reviews
 */
class ReviewsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'reviews';
    }
}
