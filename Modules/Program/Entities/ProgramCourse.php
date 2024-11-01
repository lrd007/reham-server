<?php

namespace Modules\Program\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;

class ProgramCourse extends Model
{
    protected $fillable = [];

 	public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

}
