<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests\Support\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tipoff\Support\Models\TestModelStub;

class User extends Authenticatable
{
    use TestModelStub;

    protected $guarded = [
        'id',
    ];

    public function hasRole()
    {
        return true;
    }
}
