<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('web.layout.layout');
});

Route::post('/users/token', [UserController::class, 'tokenUser'])->name('user.get.token');

Route::get('/posts/show-api', [PostController::class, 'showApi'])->name('posts.show.api');

Route::resource('posts', PostController::class);

Route::get('/books', [BookController::class, 'index'])->name('books.index');
// Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
Route::get('/books/show-api', [BookController::class, 'showApi'])->name('books.show.api');

Route::post('/categories/{category}/make-default', [CategoryController::class, 'default'])->name('categories.make.default');
Route::post('/categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
Route::resource('categories', CategoryController::class);


Route::resource('authors', AuthorController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
