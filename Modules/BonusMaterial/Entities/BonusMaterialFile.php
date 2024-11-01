<?php

namespace Modules\BonusMaterial\Entities;

use Illuminate\Database\Eloquent\Model;

class BonusMaterialFile extends Model
{
    protected $fillable = [];
    protected $appends = ['file_url'];

    public $timestamps = false;

    public function getFileUrlAttribute()
    {
        return url(uploads_files('bonus_materials', null, true) . '/' . $this->file);
    }
}
