<?php

namespace Modules\AudioBook\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Chapter\Entities\Chapter;

class AudioBook extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
