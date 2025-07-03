<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\ReviewController;

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

// Public authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {

    // Authentication routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);

    // Books CRUD
    Route::apiResource('books', BookController::class);
    Route::get('/authors/{author}/books', [BookController::class, 'byAuthor']);
    Route::get('/genres/{genre}/books', [BookController::class, 'byGenre']);

    // Authors CRUD
    Route::apiResource('authors', AuthorController::class);

    // Genres CRUD
    Route::apiResource('genres', GenreController::class);

    // Reviews CRUD
    Route::apiResource('reviews', ReviewController::class);
    Route::get('/books/{book}/reviews', [ReviewController::class, 'byBook']);
});

// Public routes for browsing (read-only)
Route::middleware('throttle:api')->group(function () {
    Route::get('/public/books', [BookController::class, 'index']);
    Route::get('/public/books/{book}', [BookController::class, 'show']);
    Route::get('/public/authors', [AuthorController::class, 'index']);
    Route::get('/public/authors/{author}', [AuthorController::class, 'show']);
    Route::get('/public/genres', [GenreController::class, 'index']);
    Route::get('/public/genres/{genre}', [GenreController::class, 'show']);
    Route::get('/public/reviews', [ReviewController::class, 'index']);
    Route::get('/public/books/{book}/reviews', [ReviewController::class, 'byBook']);
});
