<?php

use App\Http\Controllers\FileUploadController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;


Route::middleware(StartSession::class)->group(function (){
    Route::post('/upload', [FileUploadController::class, 'storeProfilePic'])->middleware('auth:sanctum');
    Route::get('/get-profile-pic', [FileUploadController::class, 'getProfilePic'])->middleware('auth:sanctum');
});

