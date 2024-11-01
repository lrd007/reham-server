<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Tag\Entities\Tag;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
    protected $fillable = [];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, BlogTag::class, 'blog_id', 'tag_id');
    }
}
