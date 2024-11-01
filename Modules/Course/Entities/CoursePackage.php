<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursePackage extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    public function getCreatedAtAttribute($value)
    {
        return showDate($value);
    }
}
