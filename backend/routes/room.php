<?php

use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::middleware(StartSession::class)->group(function () {
    Route::apiResource('rooms', RoomController::class);

});
