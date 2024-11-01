<?php

namespace Modules\Tag\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [];

    public function getCreatedAtAttribute($value)
    {
        return showDate($value);
    }
}
