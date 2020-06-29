<?php

namespace DrewRoberts\Reporting\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($video) {
            if (auth()->check()) {
                $video->creator_id = auth()->id();
            }
        });
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function markets()
    {
        return $this->hasMany(Market::class);
    }
}
