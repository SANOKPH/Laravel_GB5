<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// public routes
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);

// public routes
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);

// 

});

Route::resource('posts', PostController::class);