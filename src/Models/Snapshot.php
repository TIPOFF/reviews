<?php

namespace DrewRoberts\Reporting\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Snapshot
 *
 * @package App\Models
 */
class Snapshot extends Model
{

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [
        'date' => 'date',
    ];
}
