<?php

namespace Modules\Subscriber\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;
use Modules\Lesson\Entities\Lesson;
use Modules\Program\Entities\Program;

class SubscriberProgram extends Model
{
    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            $subscriber = $model->subscriber;
            $subscriber->is_premium = $subscriber->subscribePrograms->count() >= 3;
            $subscriber->save();
        });

        self::deleted(function($model){
            $subscriber = $model->subscriber;
            $subscriber->is_premium = $subscriber->subscribePrograms->count() >= 3;
            $subscriber->save();
        });
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class)->withTrashed();
    }

    public function programCourse($programId)
    {
        return Course::whereHas('programs', function ($query) use($programId) {
            $query->where('program_id', $programId);
        })->get();
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }


}
