<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Models;

use Illuminate\Database\Eloquent\Model;
use Tipoff\Support\Traits\HasPackageFactory;

class Snapshot extends Model
{
    use HasPackageFactory;

    protected $casts = [
        'date' => 'date',
    ];

    public function competitor()
    {
        return $this->belongsTo(app('competitor'));
    }
}
