<?php

namespace DrewRoberts\Reporting\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 *
 * @package DrewRoberts\Reporting\Models
 */
class Review extends Model
{

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $dates = [
        'reviewed_at',
        'review_updated_at',
        'replied_at',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
