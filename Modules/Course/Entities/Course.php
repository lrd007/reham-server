<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Program\Entities\Program;
use Modules\Program\Entities\ProgramCourse;
use Modules\Tag\Entities\Tag;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\Chapter\Entities\Chapter;
use LamaLama\Wishlist\Wishlistable;
use Modules\Comment\Entities\Comment;

class Course extends Model
{
    use SoftDeletes, Wishlistable;

    protected $fillable = [];
    protected $appends = ['thumb_image_url', 'file_url'];

    protected $hidden=['get_started_type','get_started_video','get_started_vimeo'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, CourseTag::class, 'course_id', 'tag_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, ProgramCourse::class, 'course_id', 'program_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function bonusMaterials()
    {
        return $this->belongsToMany(BonusMaterial::class, CourseBonusMaterial::class, 'course_id', 'bonus_material_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function courseFees()
    {
        return $this->hasMany(CourseFee::class);
    }

    public function getThumbImageUrlAttribute()
    {
        return url(uploads_images('course', null, true) . '/' . $this->thumb_image);
    }

    public function getFileUrlAttribute()
    {
        return url(uploads_images('course', null, true) . '/' . $this->file);
    }

    // public function getGetStartedVideoUrlAttribute()
    // {
    //     return url(uploads_images('course', null, true) . '/' . $this->get_started_video);
    // }

    public function getStartedFiles()
    {
        return $this->hasMany(GetStarted::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
