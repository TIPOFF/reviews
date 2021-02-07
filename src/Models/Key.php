<?php namespace Tipoff\Reviews\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Key extends BaseModel
{
    use HasPackageFactory;

    protected $guarded = ['id'];

    protected $casts = [];
}
