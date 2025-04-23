<?php

use App\Http\Controllers\HotelController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

Route::middleware(StartSession::class)->group(function () {
    Route::apiResource('hotels', HotelController::class);
});
