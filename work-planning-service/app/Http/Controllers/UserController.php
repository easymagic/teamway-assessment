<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    function getShiftsByUserId($userId){
       return User::query()->find($userId)->user_shift;
    }

    function users(){
        return User::query()->get();
    }

    function getUsersById($userId){
        return User::query()->find($userId);
    }

    function updateAccountsByUserId($userId){
        try{
            $data = request()->validate([
            'name'=>'required'
            ]);
            return User::query()->find($userId)->updateAccount($data);
        }catch(ValidationException $ex){
            return [
                'error'=>true,
                'errors'=>$ex->errors(),
                'message'=>$ex->getMessage()
            ];
        }
    }

    function getCurrentShiftsByUserId($userId){
      $shift = User::query()->find($userId)->user_shift;
      if (is_null($shift)){
        return [
            'message'=>'Current user has no assigned shifts!',
            'error'=>true
        ];
      }
      if ($shift->isCurrentShift()){
         return [
             'message'=>'Your shift is currently active',
             'error'=>false
         ];
      }
      return [
        'message'=>'Your shift is currently in-active',
        'error'=>true
      ];
    }

    function getCurrentShiftByUserIdAndShiftId($userId,$shiftId){
        $shift = User::query()->find($userId)->user_shift;
        if (is_null($shift)){
          return [
              'message'=>'Current user has no assigned shifts!',
              'error'=>true
          ];
        }
        if ($shift->id != $shiftId){
            return [
                'message'=>'Invalid shift selection!',
                'error'=>true
            ];
        }
        if ($shift->isCurrentShift()){
           return [
               'message'=>'Your shift is currently active',
               'error'=>false,
               'data'=>$shift
           ];
        }
        return [
          'message'=>'Your shift is currently in-active',
          'error'=>true,
          'data'=>$shift
        ];
      }






}
