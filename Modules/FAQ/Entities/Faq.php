<?php

namespace Modules\FAQ\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;
    protected $fillable = [];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, FaqCategory::class, 'faq_id', 'category_id');
    }
}
