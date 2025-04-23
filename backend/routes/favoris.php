<?php

use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;

Route::middleware(StartSession::class)->group(function () {
    Route::apiResource('favoris', FavoriteController::class)->only([
        'index', 'store', 'destroy'
    ]);
});
