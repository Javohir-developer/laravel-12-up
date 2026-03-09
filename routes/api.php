<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Movie\MovieController;
use App\Http\Controllers\Api\V1\Payment\PaymentController;
use App\Http\Controllers\Api\V1\Auth\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('movies', MovieController::class);

        Route::middleware('role:admin')->group(function () {
            // Karta
            Route::post('/payment/{provider}/cards',        [PaymentController::class, 'addCard']);
            Route::post('/payment/{provider}/cards/verify', [PaymentController::class, 'verifyCard']);
            // To'lov
            Route::post('/payment/{provider}/pay',                      [PaymentController::class, 'pay']);
            Route::delete('/payment/{provider}/transactions/{id}/cancel', [PaymentController::class, 'cancel']);
        });
    });
    // Webhook — auth shart emas
    Route::post('/payment/{provider}/webhook', [PaymentController::class, 'webhook']);
});
