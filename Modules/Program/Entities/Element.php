<?php

namespace Modules\Program\Entities;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    public $timestamps = false;
    protected $appends=['image_url'];

    public function getImageUrlAttribute()
    {
        return url(uploads_files('program_elements', null,true) . '/' . $this->image);
    }
}
