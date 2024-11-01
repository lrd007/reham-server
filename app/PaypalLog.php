<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaypalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'log', 'data', 'status',
    ];
    
    protected $casts = [
        'data' => 'array',
    ];
}
