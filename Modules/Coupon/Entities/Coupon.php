<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'code',
        'amount',
        'start_date',
        'end_date'
    ];

    public function getCreatedAtAttribute($value)
    {
        return showDate($value);
    }
}
