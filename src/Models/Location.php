<?php

namespace DrewRoberts\Reporting\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 *
 * @package App\Models
 */
class Location extends Model
{

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $dates = [
        'opened_at',
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

        static::creating(function ($location) {
            if (auth()->check()) {
                $location->creator_id = auth()->id();
            }
        });

        static::saving(function ($location) {
            if (empty($location->market_id)) {
                throw new \Exception('A location must be in a market.');
            }
            if (auth()->check()) {
                $location->updater_id = auth()->id();
            }
            if (empty($location->timezone)) {
                $location->timezone = 'EST';
            }
        });

        static::addGlobalScope('open', function (Builder $builder) {
            $builder->whereNull('locations.closed_at') || $builder->whereDate('locations.closed_at', '>=', date('Y-m-d'));
        });
    }

    /**
     * @var string[]
     */
    protected $with = ['market'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'manager_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'))->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insights()
    {
        return $this->hasMany(Insight::class);
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
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function snapshots()
    {
        return $this->hasManyThrough(Snapshot::class, Competitor::class);
    }

    /**
     * Get current date time at location.
     *
     * @return Carbon
     */
    public function getCurrentDateTime()
    {
        return Carbon::now($this->getPhpTzAttribute());
    }

    /**
     * Get a string for the php timezone of the location.
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

    /**
     * Get data/time at location.
     *
     * @return Carbon
     */
    public function currentDateTime()
    {
        return Carbon::now()->setTimeZone($this->php_tz);
    }

    /**
     * Apply location timezone to data/time.
     *
     * @param Carbon|string $dateTime
     * @return Carbon
     */
    public function toLocalDateTime($dateTime)
    {
        return Carbon::parse($dateTime)->setTimeZone($this->php_tz);
    }

    /**
     * Apply UTC timezone to local data/time.
     *
     * @param Carbon|string $dateTime
     * @return Carbon
     */
    public function toUtclDateTime($dateTime)
    {
        return Carbon::parse($dateTime, $this->php_tz)->setTimeZone('UTC');
    }
}
