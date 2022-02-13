<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    //
    function shifts(){
        return Shift::query()->get();
    }

    function getShiftById($shiftId){
        return Shift::query()->find($shiftId);
    }

    function getUsersByShiftId($shiftId){
        return Shift::query()->find($shiftId)->user_shifts;
    }

    function getCurrentShift(){
       return Shift::currentShift();
    }

    function getUsersByCurrentShift(){
       $shift = Shift::currentShift();
       if ($shift){
         return $shift->user_shifts;
       }
       return [];
    }

    function getUsersByCurrentShiftAndUserId($userId){
        $shift = Shift::currentShift();
        if ($shift){
          if ($shift->user_shifts()->where('user_id',$userId)->exists()){
            return $shift->user_shifts()->where('user_id',$userId)->get();
          }
          return [];
        }
        return [];
    }










}
