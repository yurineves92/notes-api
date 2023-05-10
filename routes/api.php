<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

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

// Authentication
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');

// Authenticated
Route::middleware('auth:api')->group(callback: function () {
    // User
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile/update', [UserController::class, 'update'])->name('user.update');
});