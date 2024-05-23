<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;

Route::namespace('API')->group(function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('token', [AuthController::class, 'token']);
});

Route::middleware('auth:sanctum')->post('user/{id}/cars', [UserController::class, 'list']);
Route::middleware('auth:sanctum')->post('user/cars/order', [UserController::class, 'order']);
