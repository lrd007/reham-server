<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\Lesson\Entities\Lesson;
use Modules\Program\Entities\Program;
use Modules\User\Entities\User;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id'];

    // public function program()
    // {
    //     return $this->belongsTo(Program::class, 'model_id', 'id');
    // }

    protected $parentColumn = 'parent_id';

    public function parent()
    {
        return $this->belongsTo(Comment::class,$this->parentColumn);
    }

    public function children()
    {
        return $this->hasMany(Comment::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id', 'id');
    }

    public function bonus_material()
    {
        return $this->belongsTo(BonusMaterial::class, 'bonus_material_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
