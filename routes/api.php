<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Movie\MovieController;
use App\Http\Controllers\Api\V1\Payment\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::apiResource('movies', MovieController::class);

    Route::middleware('auth:sanctum')->group(function () {
        // Karta
        Route::post('/payment/{provider}/cards',        [PaymentController::class, 'addCard']);
        Route::post('/payment/{provider}/cards/verify', [PaymentController::class, 'verifyCard']);

        // To'lov
        Route::post('/payment/{provider}/pay',                      [PaymentController::class, 'pay']);
        Route::delete('/payment/{provider}/transactions/{id}/cancel', [PaymentController::class, 'cancel']);
    });

    // Webhook — auth shart emas
    Route::post('/payment/{provider}/webhook', [PaymentController::class, 'webhook']);
});
