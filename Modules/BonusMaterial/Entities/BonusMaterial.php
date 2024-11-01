<?php

namespace Modules\BonusMaterial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Comment\Entities\Comment;

class BonusMaterial extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    public function materials()
    {
        return $this->hasMany(BonusMaterialFile::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return showDate($value);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('id','desc');
    }
}
