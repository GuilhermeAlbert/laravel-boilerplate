<?php

use App\Http\Controllers\{AuthController, UserController};
use Illuminate\Support\Facades\Route;

/**
 * Routes with middleware
 */
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/user',  [AuthController::class, 'user']);
    Route::resource('users', UserController::class);
});

/**
 * Routes without middleware
 */
Route::group([], function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
});
