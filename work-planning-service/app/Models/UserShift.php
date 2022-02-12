<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShift extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','shift_id'];

    function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    function shift(){
        return $this->belongsTo(Shift::class,'shift_id');
    }

}
