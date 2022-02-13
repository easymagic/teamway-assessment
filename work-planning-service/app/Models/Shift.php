<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['interval','start_interval','stop_interval'];
    //0-8, 8-16, 16-24
    const INTERVALS = [
        '0-8'=>[
            'interval'=>'0-8',
            'start_interval'=>0,
            'stop_interval'=>8
        ],
        '8-16'=>[
            'interval'=>'8-16',
            'start_interval'=>8,
            'stop_interval'=>16
        ],
        '16-24'=>[
            'interval'=>'16-24',
            'start_interval'=>16,
            'stop_interval'=>23
        ]
    ];

    static function getByInterval($interval){
        return self::query()->where('interval',$interval)->first();
    }

    function user_shifts(){
        return $this->hasMany(UserShift::class,'shift_id');
    }

    static function intervalIsInvalid($interval){
        if (!isset(self::INTERVALS[$interval])){
            return true;
        }
        return false;
    }

    static function intervalExists($interval){
        if (self::query()->where('interval',$interval)->exists()){
            return true;
        }
        return false;
    }

    static function addShift($interval){
       if (self::intervalIsInvalid($interval)){
          return [
              'message'=>'Invalid interval selected!',
              'error'=>true
          ];
       }
       if (self::intervalExists($interval)){
        return [
            'message'=>'Interval exists!',
            'error'=>true
        ];
       }
       $data = self::INTERVALS[$interval];
       $new = self::create($data);
       return [
           'message'=>'New shift added',
           'error'=>false,
           'data'=>$new
       ];
    }

    function updateShift($data){
        $this->update([
            'start_interval'=>$data['start_interval'],
            'stop_interval'=>$data['stop_interval']
        ]);
        return [
            'message'=>'Shift updated successfully',
            'error'=>false,
            'data'=>$this
        ];
    }

    function removeShift(){
        $userShifts = $this->user_shifts;
        foreach ($userShifts as $userShift){
            $userShift->delete();
        }
        $data = $this;
        $this->delete();
        return [
            'message'=>'Shift removed successfully',
            'error'=>false,
            'data'=>$data
        ];
    }


    function isCurrentShift(){
        $startInterval = $this->start_interval;
        $stopInterval = $this->stop_interval;
        $currentTime = Carbon::now()->hour;
        return ($currentTime >= $startInterval && $currentTime <= $stopInterval);
        // dd($currentTime);
    }

    static function currentShift(){
        // dd(90);
        $shifts = self::query()->get();
        $current = [];
        foreach ($shifts as $shift){
            if ($shift->isCurrentShift()){
               $current = $shift;
            }
        }
        // dd($current);
        return $current;
    }


}
