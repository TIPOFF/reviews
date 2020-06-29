<?php

namespace DrewRoberts\Reporting\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 *
 * @package DrewRoberts\Reporting\Models
 */
class Image extends Model
{

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($image) {
            if (auth()->check()) {
                $image->creator_id = auth()->id();
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'creator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function markets()
    {
        return $this->hasMany(Market::class);
    }
}
