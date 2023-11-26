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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Car
// Route::resource('cars', CarController::class)->only(['index','show']);
// // User
// Route::resource('users', UserController::class);
// //
// Route::resource('contracts', ContractController::class);
// Route::resource('carfeatures', CarFeatureController::class);
// Route::resource('car_owners', CarOwnerController::class);
// Route::resource('prices', PriceController::class);
// Route::resource('comments', CommentController::class);

Route::get('/cars', [CarController::class, 'index']);
Route::post('/car', [CarController::class, 'store']);

Route::get('/check-database', function () {
    try {
        DB::connection()->getPdo();
        return "Database connection is okay.";
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});