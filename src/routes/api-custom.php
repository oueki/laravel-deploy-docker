<?php

use App\Http\Controllers\CustomJsonApi\AuthorController;
use App\Http\Controllers\CustomJsonApi\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/books', [BookController::class, 'index'])->name('custom:api:v1:books.index');
Route::get('/books/{id}', [BookController::class, 'show'])->name('custom:api:v1:books.show');

Route::get('/authors', [AuthorController::class, 'index'])->name('custom:api:v1:authors.index');
Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('custom:api:v1:authors.show');
