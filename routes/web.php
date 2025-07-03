<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;

Route::get('/', function () {
    return redirect('/books');
});

Route::resource('books', BookController::class);
Route::resource('authors', AuthorController::class);
Route::resource('genres', GenreController::class);
