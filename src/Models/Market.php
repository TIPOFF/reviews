<?php

namespace DrewRoberts\Reporting\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Market
 *
 * @package App\Models
 */
class Market extends Model
{

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $dates = [
        'entered_at',
        'closed_at',
    ];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($market) {
            if (auth()->check()) {
                $market->creator_id = auth()->id();
            }
        });

        static::saving(function ($market) {
            if (auth()->check()) {
                $market->updater_id = auth()->id();
            }
            if (empty($market->entered_at)) {
                $market->entered_at = '2016-01-01';
            }
            if (empty($market->timezone)) {
                $market->timezone = 'EST';
            }
        });

        static::addGlobalScope('open', function (Builder $builder) {
            $builder->whereNull('markets.closed_at') || $builder->whereDate('markets.closed_at', '>', date('Y-m-d'));
        });

        static::addGlobalScope('locationCount', function ($builder) {
            $builder->withCount('locations');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ogimage()
    {
        return $this->belongsTo(Image::class, 'ogimage_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'creator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'updater_id');
    }

    /**
     * Get a string for the php timezone of the market.
     *
     * @return string
     */
    public function getPhpTzAttribute()
    {
        if ($this->timezone == 'CST') {
            return 'America/Chicago';
        }

        return 'America/New_York';
    }
}
