<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BloodPressureController;
use App\Http\Controllers\Api\BloodSugarController;
use App\Http\Controllers\Api\StatisticsController;
use Illuminate\Support\Facades\Route;

// S(ec) throttle: max 6 attempts per minute to prevent brute-force
Route::middleware('throttle:6,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected: requires Sanctum token
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Blood sugar CRUD
    Route::apiResource('blood-sugars', BloodSugarController::class);

    // Blood pressure CRUD
    Route::apiResource('blood-pressures', BloodPressureController::class);

    // Statistics
    Route::get('/statistics/blood-sugar/{period}', [StatisticsController::class, 'bloodSugar']);
    Route::get('/statistics/blood-pressure/{period}', [StatisticsController::class, 'bloodPressure']);
});
