<?php

use App\Http\Controllers\NegotiationController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

Route::middleware(StartSession::class)->group(function () {
    Route::apiResource('negotiations', NegotiationController::class)->only(['index', 'store']);

    Route::prefix('negotiations')->group(function () {
        Route::post('{negotiation}/accept', [NegotiationController::class, 'accept']);
        Route::post('{negotiation}/decline', [NegotiationController::class, 'decline']);
        Route::post('{negotiation}/counter', [NegotiationController::class, 'counter']);

        Route::get('my', [NegotiationController::class, 'myNegotiations']);
        Route::get('room/{roomId}', [NegotiationController::class, 'roomHistory']);
    });
});

