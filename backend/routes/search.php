<?php

use App\Http\Controllers\SearchPresetController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;


Route::middleware(StartSession::class)->group(function () {
    Route::apiResource('search-preset', SearchPresetController::class)->only(['index', 'store', 'destroy']);
    Route::get('/search-preset/{preset}/run', [SearchPresetController::class, 'search']);
});
