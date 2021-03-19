<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Models;

use Illuminate\Database\Eloquent\Model;
use Tipoff\Support\Traits\HasPackageFactory;

class Insight extends Model
{
    use HasPackageFactory;
    
    const UPDATED_AT = null;

    protected $casts = [
        'date' => 'date',
    ];

    public function location()
    {
        return $this->belongsTo(app('location'));
    }
}
