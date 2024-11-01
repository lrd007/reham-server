<?php

namespace Modules\Quiz\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Chapter\Entities\Chapter;
use Modules\Lesson\Entities\Lesson;

class Quiz extends Model
{
    use SoftDeletes;
    protected $fillable = [];

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function totalMarks()
    {
        return $this->questions()->sum('marks');
    }
}
