<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwipeController;
use Illuminate\Session\Middleware\StartSession;

Route::middleware([StartSession::class, 'auth:sanctum'])->group(function () {
    Route::apiResource('swipes', SwipeController::class);
});
