<?php

use App\Http\Controllers\Car\CarController;
use App\Http\Controllers\CarFeature\CarFeatureController;
use App\Http\Controllers\CarOwner\CarOwnerController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\Price\PriceController;
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

Route::post('/car', [CarController::class, 'store']);

//User
Route::get('/users', [UserController::class,'index']);
Route::get('/user/{user_id}', [UserController::class,'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user/{user_id}', [UserController::class,'update']);
