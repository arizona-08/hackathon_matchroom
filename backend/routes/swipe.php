<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwipeController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('swipes', SwipeController::class);
});
