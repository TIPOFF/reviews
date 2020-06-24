<?php

namespace DrewRoberts\Reporting\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Competitor
 *
 * @package App\Models
 */
class Competitor extends Model
{

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }
}
