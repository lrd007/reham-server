<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    protected $fillable = [];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return url(uploads_images('event', null, true) . '/' . $this->image);
    }
}
