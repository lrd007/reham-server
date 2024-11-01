<?php

namespace Modules\SuccessStory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\Entities\Course;
use Modules\Program\Entities\Program;
use Modules\User\Entities\User;

class SuccessStory extends Model
{
    use SoftDeletes;

    protected $fillable = [];
    protected $appends=['file_url'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getFileUrlAttribute()
    {
        return url(uploads_files(null,'success_story',true) . '/' . $this->file);
    }
}
