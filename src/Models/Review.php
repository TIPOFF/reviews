<?php

namespace Tipoff\Reviews\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Tipoff\Support\Models\BaseModel;

class Review extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'reviewed_at' => 'datetime',
        'review_updated_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    protected $with = ['location'];

    public function location()
    {
        return $this->belongsTo(config('tipoff.model_class.location'));
    }

    public function getTitleAttribute()
    {
        return $this->title_displayable ?? '5 out of 5 stars!';
    }

    public function getTextAttribute()
    {
        return $this->comment_displayable ?? $this->comment;
    }

    public function getNameAttribute()
    {
        return $this->reviewer_displayable ?? $this->reviewer;
    }

    public function getInitialAttribute()
    {
        return Str::upper(Str::limit($this->reviewer_displayable ?? $this->reviewer, 1, ''));
    }

    public function getPhotoAttribute()
    {
        return $this->is_photo_displayable == true ? $this->reviewer_photo : null;
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->reviewed_at)->setTimeZone('America/New_York')->format('M j, Y');
    }
}
