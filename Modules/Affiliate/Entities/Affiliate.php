<?php

namespace Modules\Affiliate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Program\Entities\Program;

class Affiliate extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
