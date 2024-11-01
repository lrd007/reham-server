<?php

namespace Modules\Subscriber\Entities;

use App\Country;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;
use Modules\Lesson\Entities\LessonCompletion;
use Modules\Payment\Entities\Payment;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\Cast\Double;

class Subscriber extends Model
{
    use SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'mobile_no', 'country_id', 'user_id', 'is_premium'];
    protected $appends=['image_url','full_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function subscribePrograms()
    {
        return $this->hasMany(SubscriberProgram::class);
    }

    public function subscribeProgramsCount()
    {
        return $this->hasMany(SubscriberProgram::class);
    }

    public function CourseComplete($course_id,$chapter_id = null){
        $count = $lessons  = 0;
        $course = Course::FindOrFail($course_id);
        if($course) {

            if (!is_null($chapter_id)) {

                foreach ($course->chapters as $chapter) {
                    if($chapter->id == $chapter_id){
                        $lessons = $chapter->lessons->count();
                        foreach ($chapter->lessons as $lesson) {
                            // check now if user complete
                            $exists = LessonCompletion::where('subscriber_id', $this->id)->where('lesson_id', $lesson->id)->exists();
                            if ($exists) {
                                $count++;
                            }
                        }
                        if ($lessons == 0) {
                            return 0;
                        }
                        return number_format((float)(($count / $lessons) * 100), 2);
                    }

                }
                return 0;

            } else {

                foreach ($course->chapters as $chapter) {
                    $lessons = $chapter->lessons->count();
                    foreach ($chapter->lessons as $lesson) {
                        // check now if user complete
                        $exists = LessonCompletion::where('subscriber_id', $this->id)->where('lesson_id', $lesson->id)->exists();
                        if ($exists) {
                            $count++;
                        }
                    }
                    if ($lessons == 0) {
                        return 0;
                    }
                    return number_format((float)(($count / $lessons) * 100), 2);
                }

            }
        }else{
            return 0;
        }


    }

    public function subscribeLessonsCount(){
        $count = 0;
        foreach ($this->subscribePrograms as $program){
            if(isset($program->course->chapters)){
                foreach ($program->course->chapters as $chapter){
                    $count += $chapter->lessons->count();
                }
            }else{
                $count = 0;
            }

        }
        return $count;
    }

    public function lessonsCompleteCount():int {
        return $this->hasMany(LessonCompletion::class)->count();
    }

    public function SubscribtionPersent(): string{
        if($this->subscribeLessonsCount() == 0){
            return 0;
        }
        return number_format(
            (float)(($this->lessonsCompleteCount() / $this->subscribeLessonsCount()) * 100),
            2
            );
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    public function getImageUrlAttribute()
    {
        return url(uploads_files('subscriber', null,true) . '/' . $this->image);
    }

}
