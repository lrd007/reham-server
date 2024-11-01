<?php

namespace Modules\Lesson\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Chapter\Entities\Chapter;
use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\Comment\Entities\Comment;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;

class Lesson extends Model
{

    use SoftDeletes;
    protected $fillable = [];
    protected $appends = ['thumb_image_url', 'video_url', 'document_url', 'audio_url', 'is_completed'];

    public function bonusMaterials()
    {
        return $this->belongsToMany(BonusMaterial::class, LessonBonusMaterial::class, 'lesson_id', 'bonus_material_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function getThumbImageUrlAttribute()
    {
        return url(uploads_images('lesson', null, true) . '/' . $this->thumb_image);
    }

    public function getVideoUrlAttribute()
    {
        return url(uploads_images('files', null, true) . '/' . $this->video);
    }

    public function getAudioUrlAttribute()
    {
        return url(uploads_files('lesson', null, true) . '/' . $this->audio);
    }

    public function getDocumentUrlAttribute()
    {
        return url(uploads_files('lesson', null, true) . '/' . $this->document);
    }

    public function getIsCompletedAttribute()
    {
       // dd($this->lessonCompleted->count());
    //    if (Auth::user() && Auth::user()->subscriber) {
    //     return $this->lessonCompleted()->count() ? true : false;
    //    }
    //    else
    //    {
    //     return false;
    //    }
    return $this->lessonCompleted() && $this->lessonCompleted()->count() ? true : false;
    }

    public function lessonCompleted()
    {
        if (Auth::user() && Auth::user()->subscriber) {
            return $this->hasOne(LessonCompletion::class)->where('subscriber_id', Auth::user()->subscriber->id);
        } else {
            return null;
        }
    }

    public function lessonCompletedForAdmin()
    {
        return $this->hasOne(LessonCompletion::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
