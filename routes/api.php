<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ReactionController;
use App\Http\Controllers\Api\SharePostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 


// public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['prefix' => 'reactions'], function () {
    Route::post('/create', [ReactionController::class, 'store']);
    Route::get('/list', [ReactionController::class, 'index']);
});



// protected routes
Route::middleware('auth:sanctum')->group(function () {
    // logout route
    Route::post('/logout', [AuthController::class, 'logout']);

    // user route
    Route::group(['prefix' => 'user'], function () {
        Route::get('/profile', [AuthController::class, 'index'])->name('user.profile');
        Route::put('/profile', [AuthController::class, 'update'])->name('user.update.profile');

        Route::get('/friend-request', [UserController::class, 'requested'])->name('user.request'); // get friend we are requesting
    });
    
    // friend routes
    Route::group(['prefix' => 'friends'], function () {
        Route::get('/', [FriendController::class, 'index'])->name('friends.list'); // list all friends who accepted 
        Route::get('/request', [FriendController::class, 'requested'])->name('friends.requested'); // get friends who requested to us
        Route::post('/', [FriendController::class, 'store'])->name('friends.create'); // add to friends
        Route::put('/accept/{id}', [FriendController::class, 'acceptFriend'])->name('friends.accept');
    });

    // post routes
    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.list');
        Route::get('/{id}', [PostController::class, 'show'])->name('posts.show');
        Route::post('/', [PostController::class, 'store'])->name('posts.create');
        Route::post('/{id}', [PostController::class, 'update'])->name('posts.update'); // hardly to use the 'put' method to update posts that have images
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.delete');

        Route::get('/{id}/comments', [PostController::class, 'comments'])->name('posts.comments');
        Route::get('/{id}/likes', [PostController::class, 'likes'])->name('posts.likes');
    });

    /**
     * 
     * @name Share
     * @use App\Http\Controllers\Api\SharePostController;
     */
    Route::group(['prefix' => 'share'], function () {
        Route::get('/posts', [SharePostController::class, 'index'])->name('share.post.list');
        Route::post('/posts', [SharePostController::class, 'store'])->name('share.post.create');
        Route::delete('/posts/{id}', [SharePostController::class, 'destroy'])->name('share.post.delete');
    });

    // comment routes
    Route::group(['prefix' => 'comments'], function () {
        Route::get('/', [CommentController::class, 'index'])->name('comments.list');
        Route::get('/{id}', [CommentController::class, 'show'])->name('comments.show');
        Route::post('/', [CommentController::class, 'store'])->name('comments.create');
        Route::put('/{id}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/{id}', [CommentController::class, 'destroy'])->name('comments.delete');
    });

    // like routes
    Route::group(['prefix' => 'likes'], function () {
        Route::resource('/', LikeController::class);
    });
});