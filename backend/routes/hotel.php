<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelAccessController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

Route::middleware(StartSession::class)->group(function () {
    Route::apiResource('hotels', HotelController::class);

    Route::post('/validate-hotel-key', [HotelAccessController::class, 'validateKey']);
    Route::post('/generate-hotel-key', [HotelAccessController::class, 'generate']);
});
