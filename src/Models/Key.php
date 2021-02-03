<?php namespace Tipoff\Reviews\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tipoff\Support\Models\BaseModel;

class Key extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [];
}
