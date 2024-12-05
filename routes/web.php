<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
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

Route::get('/user-logout', [UserController::class, 'Logout'])->middleware([TokenVerification::class]);

Route::group([TokenVerification::class], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/customer/home', [CustomerController::class, 'home']);
    Route::get('/employee/home', [EmployeeController::class, 'home']);
});

Route::post('/upload-image', [ProfileController::class, 'uploadImage']);
Route::get('/profile-show', [ProfileController::class, 'profileShow']);
Route::post('/update-profile', [ProfileController::class, 'updateProfile']);
Route::post('/delete-profile', [ProfileController::class, 'deleteProfile']);

Route::post('/create-employee', [EmployeeController::class, 'createEmployee']);
Route::get('/show-employee', [EmployeeController::class, 'showEmployee']);
Route::post('/update-employee/{id}', [EmployeeController::class, 'updateEmployee']);
Route::get('/delete-employee', [EmployeeController::class, 'deleteEmployee']);

Route::resources([
    'movies' => MovieController::class,
]); // movie feature CRUD API for admin

