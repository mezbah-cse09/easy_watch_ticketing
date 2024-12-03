<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerification;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\HallController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return "view('welcomez')";
});

Route::post('/user-registration', [UserController::class, 'UserRegistration']);

Route::post('/user-login', [UserController::class, 'UserLogin']);

Route::post('/sent-otp', [UserController::class, 'SentOTP']);

Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);

Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerification::class]);

Route::get('/user-logout', [UserController::class, 'Logout']);



Route::post('/locations', [LocationController::class, 'Create']);  // Create location
Route::put('/locations/{id}', [LocationController::class, 'Update']);  // Update location
Route::delete('/locations/{id}', [LocationController::class, 'Delete']);  // Delete location
Route::get('location', [LocationController::class, 'LocationById']);  // LocationById
Route::get('locations', [LocationController::class, 'SelectAllLocation']);  // SelectAllHall



Route::post('/halls', [HallController::class, 'Create']);  // Create hall
Route::put('/hall/{id}', [HallController::class, 'update']);  // Update hall
Route::delete('/halls/{id}', [HallController::class, 'Delete']);  // Delete hall
Route::get('/hall', [HallController::class, 'HallById']);  // HallById hall
Route::get('/halls', [HallController::class, 'SelectAllHall']);  // SelectAllHall
