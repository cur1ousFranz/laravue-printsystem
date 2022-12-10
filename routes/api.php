<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShopQueueController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerShopController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ServicePriceController;
use App\Http\Controllers\BusinessOwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerTransactionController;
use App\Http\Controllers\ReviewController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Customer
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::post('/upload', [CustomerShopController::class, 'upload']);
    Route::get('/customer/shop/{shop}', [CustomerShopController::class, 'show']);
    Route::get('/customer/shop', [CustomerShopController::class, 'index']);
    Route::get('/customer/transaction', [CustomerTransactionController::class, 'index']);
    Route::get('/customer/notification', [NotificationController::class, 'customerNotifications']);
    Route::get('/customer/notification/{notification}', [NotificationController::class, 'customerNotificationsDetails']);
    Route::post('/review', [ReviewController::class, 'store']);
    Route::get('/review/shop/{shop}', [ReviewController::class, 'show']);

    // Business Owner
    Route::get('/shop/report/queue', [ShopQueueController::class, 'reportQueue']);
    Route::get('/shop/queue', [ShopQueueController::class, 'index']);
    Route::put('/shop/queue/{queue}', [ShopQueueController::class, 'update']);
    Route::get('/shop/application', [BusinessOwnerController::class, 'index']);
    Route::get('/shop/{shop}', [ShopController::class, 'show']);
    Route::put('/shop/{shop}', [ShopController::class, 'update']);
    Route::post('/shop/image', [ShopController::class, 'updateImage']);
    Route::get('/shop', [BusinessOwnerController::class, 'show']);
    Route::put('/service/{service}', [ServiceController::class, 'update']);
    Route::put('/shop/documents/{shop}', [ShopController::class, 'storeDocuments']);
    Route::delete('/shop/service/documents/{shop}', [ShopController::class, 'deleteServiceDocuments']);
    Route::put('/shop/service/document/price/{shop}', [ServicePriceController::class, 'setDocumentsPrice']);
    Route::get('/owner/notification', [NotificationController::class, 'ownerNotifications']);
    Route::get('/owner/notification/{notification}', [NotificationController::class, 'ownerNotificationsDetails']);


    // Admin
    Route::get('/application', [ApplicationController::class, 'index']);
    Route::get('/application/{application}', [ApplicationController::class, 'show']);
    Route::put('/application/{application}', [ApplicationController::class, 'update']);
    Route::get('/transaction/shop/{shop}', [TransactionController::class, 'show']);
    Route::put('/transaction/shop/{shop}', [TransactionController::class, 'update']);
});

Route::post('/success', [CustomerShopController::class, 'checkoutSuccess']);
Route::post('/verify', [AuthController::class, 'verify']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/owner', [AuthController::class, 'registerOwner']);
Route::post('/login', [AuthController::class, 'login']);
