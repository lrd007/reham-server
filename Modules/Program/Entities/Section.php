<?php

namespace Modules\Program\Entities;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public $timestamps = false;

    public function program()
    {
        return $this->belongsTo(Program::class,'program_id');
    }

    public function elements()
    {
        return $this->hasMany(Element::class);
    }
}
