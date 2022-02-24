<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const DEFAULT_EMAIL = 'default@domain.com';

    function user_shift(){
       return $this->belongsTo(UserShift::class,'id','user_id');
    }

    function addShift($shift_id){
        if ($this->user_shift()->exists()){
          return [
              'message'=>'User cannot have more than one shift!',
              'error'=>true
          ];
        }
        $userShift = $this->user_shift()->create([
            'shift_id'=>$shift_id,
            'user_id'=>$this->id
        ]);
        return [
          'message'=>'Shift added successfully.',
          'error'=>false,
          'data'=>$userShift
        ];
    }

    function removeShift(){
        if (!$this->user_shift()->exists()){
            return [
                'message'=>'User does not have an existing shift!',
                'error'=>true
            ];
          }
          $userShift = $this->user_shift;
          $userShift = $this->user_shift->delete();
          return [
            'message'=>'Shift removed successfully.',
            'error'=>false,
            'data'=>$userShift
          ];
    }

    static function createDefaultUser(){
        if (self::query()->where('email',self::DEFAULT_EMAIL)->exists()){
          return self::query()->where('email',self::DEFAULT_EMAIL)->first();
        }
        $new = self::create([
          'email'=>self::DEFAULT_EMAIL,
          'name'=>'Default User',
          'password'=>Hash::make('password')
        ]);
        // dd($new);
        return $new;
    }

    function updateAccount($data){
        $this->update([
            'name'=>$data['name']
        ]);
        return [
            'message'=>'Account updated successfully',
            'error'=>false,
            'data'=>$this
        ];
    }

}
