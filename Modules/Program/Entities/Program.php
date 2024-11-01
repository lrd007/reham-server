<?php

namespace Modules\Program\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Chapter\Entities\Chapter;
use Modules\Course\Entities\Course;
use Modules\Lesson\Entities\Lesson;
use Modules\User\Entities\User;

class Program extends Model
{
    use SoftDeletes;


    protected $fillable = [];
    protected $appends=['thumb_image_url'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, ProgramCourse::class, 'program_id', 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function getThumbImageUrlAttribute()
    {
        return url(uploads_images('program', null,true) . '/' . $this->thumb_image);
    }

    function chapters()
    {
        return $this->hasManyThrough(Chapter::class, Course::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

}
