<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\BookingController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Services
    Route::get('services', [ServiceController::class, 'index']);
    Route::post('services', [ServiceController::class, 'store']);
    Route::get('services/{service}', [ServiceController::class, 'show']);
    Route::put('services/{service}', [ServiceController::class, 'update']);
    Route::delete('services/{service}', [ServiceController::class, 'destroy']);
    Route::put('services/{service}/status', [ServiceController::class, 'updateStatus']);
    Route::patch('services/{service}/status', [ServiceController::class, 'updateStatus']);

    // Bookings
    Route::get('bookings', [BookingController::class, 'index']);
    Route::post('bookings', [BookingController::class, 'store']);
    Route::put('bookings/{booking}/status', [BookingController::class, 'updateStatus']);

    // User Profile
    Route::get('user', [AuthController::class, 'user']);
    Route::put('user', [AuthController::class, 'update']);

});
