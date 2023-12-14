<?php

use App\Http\Controllers\Car\CarController;
use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\Timer\TimerController;
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
/*
Format of Request Object
{
    "LICENSE_PLATE": "37K-12350", [required]
    "OWNER_ID": "U0048", [required]
    "NAME": "VINFAST VF8 ECO 2022", [required]
    "LOCATION": "Hồ Chí Minh", [required]
    "BRAND": "VINFAST", [required]
    "SEAT": 5, [required]
    "TRANSMISSION": "Số tự động", [required]
    "FUEL": "Điện", [required]
    "CONSUMPTION": 400, [required]
    "PRICE": 1250000, [required]
    "SERVICE_FEE": 148000, [required]
    "INSURANCE_FEE": 148000, [required]
    "LAST_CHECK": "2023-09-03",
    "DESCRIPTION": "VINFAST VF8 ECO 2023\nXe không đổ xăng ko mùi hôi, phí sạc tính theo odo 1200đ/km tiết kiệm 1/3 so với xe xăng",
    "MAP": "Y",
    "BLUETOOTH": "Y",
    "CAMERA_360": "N",
    "CAMERA_SIDES": "Y",
    "CAMERA_JOURNEY": "N",
    "CAMERA_BACK": "Y",
    "TIRE_SENSOR": "Y",
    "IMPACT_SENSOR": "Y",
    "SPEED_WARNING": "Y",
    "SKY_WINDOW": "Y",
    "GPS": "Y",
    "CHILD_SEAT": "Y",
    "USB": "Y",
    "SPARE_TIRE": "N",
    "DVD": "N",
    "ETC": "Y",
    "AIRBAG": "N",
    "PICKUP_COVER": "Y",
    "FRONT_IMG": "VinFast-F",
    "BACK_IMG": "VinFast-B",
    "LEFT_IMG": "VinFast-L",
    "RIGHT_IMG": "VinFast-R"
}
*/
// Car
Route::get('/cars', [CarController::class,'index']);
Route::get('/car/{LICENSE_PLATE}', [CarController::class,'show']);
Route::post('/car', [CarController::class, 'store']);
Route::put('/car/{LICENSE_PLATE}', [CarController::class,'update']);
Route::delete('/car/{LICENSE_PLATE}', [CarController::class,'destroy']);
Route::post('/car/filter', [CarController::class,'filter']);
Route::get('/car/ofowner/{OWNER_ID}', [CarController::class,'getCarsOfOwner']);

// Format of Request Object
/*
{
    "USER_ID": "U0048", [Create automatically, readonly] [required]
    "PASSWORD": "password48", [required]
    "FIRST_NAME": "Robert", [required]
    "LAST_NAME": "Toni", [required]
    "DOB": "1993-12-18", [required]
    "GENDER": "M", [required]
    "EMAIL": "ToniMan93@example.com", [required]
    "SDT": "33311224677",
    "GPLX": "GPLX048",
    "LOCATION": "Hồ Chí Minh"
}
*/
//User
Route::get('/users', [UserController::class,'index']);
Route::get('/user/{user_id}', [UserController::class,'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user/{user_id}', [UserController::class,'update']);
Route::delete('/user/{user_id}', [UserController::class,'destroy']);

// Contract Rent
Route::get('/contracts', [ContractController::class,'index']);
Route::get('/contract/{contract_id}', [ContractController::class,'show']);
Route::post('/contract', [ContractController::class, 'store']);
Route::put('/contract/{contract_id}', [ContractController::class,'update']);
Route::delete('/contract/{contract_id}', [ContractController::class,'destroy']);
Route::post('/contract/filter', [ContractController::class,'filter']);

// Comment
Route::get('/comments', [ContractController::class,'index']);
Route::post('/comment', [ContractController::class, 'store']);
Route::put('/comment', [ContractController::class,'update']);
Route::delete('/comment', [ContractController::class,'destroy']);
Route::post('/comment/filter', [ContractController::class,'filter']);

// GetTimer
Route::get('/timer/{user_id}', [TimerController::class,'getTimer']);