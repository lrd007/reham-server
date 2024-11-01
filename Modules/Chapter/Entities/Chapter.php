<?php

namespace Modules\Chapter\Entities;
use Carbon\CarbonInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\Course\Entities\Course;
use Modules\Lesson\Entities\Lesson;
use Modules\Lesson\Entities\LessonCompletion;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;

class Chapter extends Model
{
    use SoftDeletes;

    protected $fillable = [];
    protected $appends = ['thumb_image_url', 'completion_percentage'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function bonusMaterials()
    {
        return $this->belongsToMany(BonusMaterial::class, ChapterBonusMaterial::class, 'chapter_id', 'bonus_material_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }


    public function TimeOfLessons(){
      $total = 0;
        foreach($this->lessons()->get() as $lesson) {
            $explodedTime = explode(':', $lesson->duration);
            $minutes= $explodedTime[0]*60;
            $total += $minutes;
        }
        return floor($total/60);
    }

    public function getThumbImageUrlAttribute()
    {
        return url(uploads_images('chapter', null, true) . '/' . $this->thumb_image);
    }

    public function getCompletionPercentageAttribute()
    {
        if (Auth::user() && Auth::user()->subscriber) {
            $chapterLessonCount = $this->lessons()->count();
            $chapter_lessons = $this->lessons->pluck('id');

            $subscriberCompletedLessonCount = LessonCompletion::where('subscriber_id', Auth::user()->subscriber->id)->whereIn('lesson_id', $chapter_lessons)->count();
            if($chapterLessonCount>0)
            {
                $percentage = ($subscriberCompletedLessonCount / $chapterLessonCount) * 100;
                return round($percentage,2);
            }
            else
            {
                return 0;
            }

        } else {
            return 0;
        }
    }


}
