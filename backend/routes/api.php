<?php

use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(StartSession::class, 'auth:sanctum');

require __DIR__.'/auth.php';
require __DIR__.'/hotel.php';
require __DIR__.'/room.php';
require __DIR__.'/swipe.php';
require __DIR__.'/negotiation.php';
require __DIR__.'/favoris.php';
require __DIR__.'/map.php';
require __DIR__.'/file_upload.php';
require __DIR__.'/search.php';
require __DIR__.'/reservation.php';
