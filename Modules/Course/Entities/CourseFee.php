<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;

class CourseFee extends Model
{
    protected $fillable = [];
    public $timestamps = false;

    public function coursePackage()
    {
        return $this->belongsTo(CoursePackage::class, 'course_package_id');
    }
}
