<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');


// protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // post routes
    // Route::resource('posts', PostController::class);

    // post route prefiex
    Route::get('/posts/list', [PostController::class, 'index'])->name('posts.list');
    Route::post('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/show/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/update/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/delete/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
});
    



