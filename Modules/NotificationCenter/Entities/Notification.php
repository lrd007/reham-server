<?php

namespace Modules\NotificationCenter\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\Entities\Course;
use Modules\User\Entities\User;

class Notification extends Model
{
    use SoftDeletes;

    public static $sendTo = [
        'User',
        'Group'
    ];

    public static $mediumType = [
        'Email',
        'Web'
    ];

    public static $status = [
        'Saved',
        'Send',
        'Schedule'
    ];

    public static $statusColor = [
        'primary',
        'success',
        'warning'
    ];

    protected $fillable = [];
    protected $appends=['time'];
    
    public function media()
    {
        return $this->hasMany(NotificationMedia::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, NotificationUser::class, 'notification_id', 'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, NotificationCourse::class, 'notification_id', 'course_id');
    }

    public function getTimeAttribute()
    {
        return $this->created_at->diffForHumans();;
    }
}
