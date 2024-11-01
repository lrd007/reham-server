<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Program\Entities\Program;

class Cart extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'wishlist';

    public function program(){
        return $this->hasOne(Program::class,'id','program_id');
    }
}
