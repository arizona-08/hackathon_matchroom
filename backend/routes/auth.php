<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;


Route::post('/register', [RegisterUserController::class, 'store']);

Route::middleware(StartSession::class)->group(function () {
    Route::post('/login', [AuthenticationController::class, 'store']);
    Route::post('/logout', [AuthenticationController::class, 'destroy'])->middleware('auth:sanctum');
    Route::get('/users', fn () => \App\Models\User::select('id', 'name', 'email')->get());

});
