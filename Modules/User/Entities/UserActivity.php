<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
