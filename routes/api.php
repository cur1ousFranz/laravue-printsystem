<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessOwnerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShopController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Business Owner
    Route::get('/shop/application', [BusinessOwnerController::class, 'index']);
    Route::get('/shop/{shop}', [ShopController::class, 'show']);
    Route::put('/shop/{shop}', [ShopController::class, 'update']);
    Route::get('/shop', [BusinessOwnerController::class, 'show']);
    Route::put('/service/{service}', [ServiceController::class, 'update']);

    // Admin
    Route::get('/application', [ApplicationController::class, 'index']);
    Route::get('/application/{application}', [ApplicationController::class, 'show']);
    Route::put('/application/{application}', [ApplicationController::class, 'update']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/owner', [AuthController::class, 'registerOwner']);
Route::post('/login', [AuthController::class, 'login']);
