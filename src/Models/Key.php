<?php namespace Tipoff\Reviews\Models;

use Tipoff\Support\HasPackageFactory;
use Tipoff\Support\Models\BaseModel;

class Key extends BaseModel
{
    use HasPackageFactory;

    protected $guarded = ['id'];

    protected $casts = [];
}
