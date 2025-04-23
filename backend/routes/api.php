<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__.'/auth.php';
require __DIR__.'/hotel.php';
require __DIR__.'/room.php';
require __DIR__.'/swipe.php';
