<?php

use App\Http\Controllers\MapDataController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

Route::middleware(StartSession::class)->group(function () {
    Route::get('/map-data', [MapDataController::class, 'index']);
});
