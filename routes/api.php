<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(UserController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('userAuth', [UserController::class, 'getAuthUser']);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::get('authPosts', [PostController::class, 'getAuthPosts']);
    Route::get('profile/{user_id}', [PostController::class, 'getUserPosts']);
    Route::post('comment/{post_id}', [CommentController::class, 'createComment']);
    Route::delete('comment/{id}', [CommentController::class, 'deleteComment']);
    Route::put('comment/{id}', [CommentController::class, 'updateComment']);
    Route::post('like/{post_id}', [LikeController::class, 'index']);
    Route::delete('like/{id}', [LikeController::class, 'deleteLike']);
});
