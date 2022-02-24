<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    function getShiftsByUserId($userId){
        // dd([]);
        // return User::query()->find($userId);
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
      if ($shift->shift->isCurrentShift()){
         return [
             'message'=>'Your shift is currently active',
             'error'=>false,
             'data'=>$shift->shift
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
              'error'=>true,
            //   'status'=>'inactive'
          ];
        }
        if ($shift->shift_id != $shiftId){
            return [
                'message'=>'Invalid shift selection!',
                'error'=>true,
                // 'status'=>'inactive'
            ];
        }
        if ($shift->shift->isCurrentShift()){
           return [
               'message'=>'Your shift is currently active',
               'error'=>false,
               'data'=>$shift,
               'status'=>'active'
           ];
        }
        return [
          'message'=>'Your shift is currently in-active',
          'error'=>true,
          'data'=>$shift,
          'status'=>'inactive'
        ];
      }

      function addShiftToUser($userId){
        try {
            $data = request()->validate([
               'shift_id'=>'required|exists:shifts,id'
            ]);
            return User::query()->find($userId)->addShift($data['shift_id']);
        } catch (ValidationException $ex) {
            return [
                'error'=>true,
                'errors'=>$ex->errors(),
                'message'=>$ex->getMessage()
            ];
        }
      }

      function removeShiftFromUser($userId){
        return User::query()->find($userId)->removeShift();
      }


}
