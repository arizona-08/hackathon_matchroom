<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Controllers\FavoriteController;

Route::middleware([StartSession::class, 'auth:sanctum'])->group(function () {
    Route::get('/favoris', [FavoriteController::class, 'index']);
    Route::post('/favoris', [FavoriteController::class, 'store']);
    Route::delete('/favoris/{favorite}', [FavoriteController::class, 'destroy']);
});
