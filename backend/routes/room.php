<?php

use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomImageController;

Route::middleware(StartSession::class)->group(function () {
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('room-images', RoomImageController::class)->only([
        'index', 'store', 'destroy'
    ]);
});

