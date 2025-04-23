<?php

use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwipeController;

Route::middleware(StartSession::class)->group(function () {
    Route::apiResource('swipes', SwipeController::class);
});
