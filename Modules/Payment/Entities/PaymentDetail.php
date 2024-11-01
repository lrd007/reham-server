<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CoursePackage;
use Modules\Program\Entities\Program;

class PaymentDetail extends Model
{
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function package()
    {
        return $this->belongsTo(CoursePackage::class, 'course_package_id');
    }
}
