<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tipoff\Support\Traits\HasPackageFactory;

class Competitor extends Model
{
    use HasPackageFactory;

    protected $guarded = ['id'];
    protected $casts = [
    ];


    public function market()
    {
        return $this->belongsTo(app('market'));
    }

    public function snapshots()
    {
        return $this->hasMany(app('snapshot'));
    }

    public function location()
    {
        return $this->belongsTo(app('location'));
    }

    public function getNameAttribute($value)
    {
        return explode('|', $value)[0];
    }

    public function getReviewsAttribute()
    {
        $snapshot = app('snapshot');

        $recent = $snapshot::where('competitor_id', $this->id)->orderByDesc('date')->first();

        if (! isset($recent)) {
            return '?';
        }

        return $recent->reviews;
    }

    public function getWeeklyReviewsAttribute()
    {
        $snapshot = app('snapshot');

        // Snapshots are run every Wednesday morning.
        $today = Carbon::now('America/New_York');
        if ($today->dayOfWeek == Carbon::WEDNESDAY) {
            $firstdate = $today;
        } else {
            $firstdate = new Carbon('last wednesday');
        }

        $recent = $snapshot::where('competitor_id', $this->id)->where('date', $firstdate->format('Y-m-d'))->first();
        $prior = $snapshot::where('competitor_id', $this->id)->where('date', $firstdate->subDays(7)->format('Y-m-d'))->first();

        if (! isset($recent) || ! isset($prior)) {
            return '?';
        }

        return $recent->reviews - $prior->reviews;
    }

    public function getMonthlyReviewsAttribute()
    {
        $snapshot = app('snapshot');
        
        // Snapshots are run on the 1st of every month.
        $firstdate = Carbon::now('America/New_York')->firstOfMonth();

        $recent = $snapshot::where('competitor_id', $this->id)->where('date', $firstdate->format('Y-m-d'))->first();
        $prior = $snapshot::where('competitor_id', $this->id)->where('date', $firstdate->subMonths(1)->format('Y-m-d'))->first();

        if (! isset($recent) || ! isset($prior)) {
            return '?';
        }

        return $recent->reviews - $prior->reviews;
    }
}
