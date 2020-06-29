<?php

namespace DrewRoberts\Reporting\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Insight
 *
 * @package App\Models
 */
class Insight extends Model
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

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
