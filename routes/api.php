<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DeviceController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\RentalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All routes are prefixed with /api automatically
|
*/

// Public routes
Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    
    // Public device routes
    Route::apiResource('devices', DeviceController::class)->only(['index', 'show']);
    
    // Public category routes
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
    Route::get('categories/{category}/devices', [CategoryController::class, 'devices']);
});

// Protected routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/profile', [AuthController::class, 'profile']);
    Route::put('auth/profile', [AuthController::class, 'updateProfile']);
    
    // User rental routes
    Route::get('rentals/user', [RentalController::class, 'userRentals']);
    Route::apiResource('rentals', RentalController::class);
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        // Dashboard & Statistics
        Route::get('dashboard', [DashboardController::class, 'index']);
        Route::get('statistics', [DashboardController::class, 'statistics']);
        
        // Admin device management
        Route::apiResource('devices', DeviceController::class)->except(['index', 'show']);
        
        // Admin category management
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        
        // Admin user management
        Route::apiResource('users', UserController::class)->except(['show']);
        
        // Admin rental management
        Route::get('rentals', [RentalController::class, 'index']);
        Route::put('rentals/{rental}/status', [RentalController::class, 'updateStatus']);
    });
});

// Fallback Route
Route::fallback(function () {
    return response()->json([
        'message' => 'API endpoint not found'
    ], 404);
});