<?php

namespace Modules\Lesson\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonCompletion extends Model
{
    use HasFactory;

    protected $fillable = ["subscriber_id", "lesson_id"];

    protected static function newFactory()
    {
        return \Modules\Lesson\Database\factories\LessonCompletionFactory::new();
    }
}
