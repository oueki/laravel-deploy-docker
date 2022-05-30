<?php

use App\Http\Controllers\OpenApi\CommentController;
use App\Http\Controllers\OpenApi\FileController;
use App\Http\Controllers\OpenApi\HomeController;
use App\Http\Controllers\OpenApi\PostController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'home']);

Route::post('/users/auth-token', [UserController::class, 'tokenUserAuth'])->name('user.get.authtoken');


//Route::apiResource('posts', PostController::class);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'delete']);

Route::get('/comments', [CommentController::class, 'index']);

Route::post('/upload', [FileController::class, 'upload']);
Route::post('/upload-private', [FileController::class, 'uploadPrivate']);
