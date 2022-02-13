<?php

use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User Resource
Route::get('users/{userId}/shifts',[UserController::class,'getShiftsByUserId']);
Route::get('users',[UserController::class,'users']);
Route::get('users/{userId}',[UserController::class,'getUsersById']);
Route::post('users/{userId}/accounts',[UserController::class,'updateAccountsByUserId']);
Route::get('users/{userId}/shifts/current',[UserController::class,'getCurrentShiftsByUserId']);
Route::get('users/{userId}/shifts/{shiftId}/current',[UserController::class,'getCurrentShiftByUserIdAndShiftId']);
Route::get('users/{userId}/shifts',[UserController::class,'addShiftToUser']);
Route::delete('users/{userId}/shifts',[UserController::class,'removeShiftFromUser']);


// Shift Resource
Route::get('shifts',[ShiftController::class,'shifts']);
Route::get('shifts/{shiftId}',[ShiftController::class,'getShiftById']);
Route::get('shifts/{shiftId}/users',[ShiftController::class,'getUsersByShiftId']);
Route::get('shifts/current',[ShiftController::class,'getCurrentShift']);
Route::get('shifts/current/users',[ShiftController::class,'getUsersByCurrentShift']);
Route::get('shifts/current/users/{userId}',[ShiftController::class,'getUsersByCurrentShiftAndUserId']);



