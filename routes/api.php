<?php

use App\Http\Controllers\Car\CarController;
use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/check-database', function () {
    try {
        DB::connection()->getPdo();
        return "Database connection is okay.";
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});
// Car
Route::get('/cars', [CarController::class,'index']);
Route::get('/car/{LICENSE_PLATE}', [CarController::class,'show']);
Route::post('/car', [CarController::class, 'store']);
Route::put('/car/{LICENSE_PLATE}', [CarController::class,'update']);
Route::delete('/car/{LICENSE_PLATE}', [CarController::class,'destroy']);

//User
Route::get('/users', [UserController::class,'index']);
Route::get('/user/{user_id}', [UserController::class,'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user/{user_id}', [UserController::class,'update']);
Route::delete('/user/{user_id}', [UserController::class,'destroy']);

//Contract Rent
Route::get('/contracts', [ContractController::class,'index']);
Route::get('/contract/{contract_id}', [ContractController::class,'show']);
Route::post('/contract', [ContractController::class, 'store']);
Route::put('/contract/{contract_id}', [ContractController::class,'update']);
Route::delete('/contract/{contract_id}', [ContractController::class,'destroy']);