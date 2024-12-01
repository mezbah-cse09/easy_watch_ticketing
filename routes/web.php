<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerification;
use Illuminate\Support\Facades\Route;

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

Route::post('/user-registration', [UserController::class, 'UserRegistration']);

Route::post('/user-login', [UserController::class, 'UserLogin']);

Route::post('/sent-otp', [UserController::class, 'SentOTP']);

Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);

Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerification::class]);

Route::get('/user-logout', [UserController::class, 'Logout']);

Route::resources([
    'movies' => MovieController::class,
]); // movie feature CRUD API for admin 
