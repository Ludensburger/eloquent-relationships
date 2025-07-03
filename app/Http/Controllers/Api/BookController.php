<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * Display a listing of books
     */
    public function index(Request $request): JsonResponse
    {
        $query = Book::with(['author', 'genres', 'reviews']);

        // Apply sorting if requested
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'rating':
                    $query->withAvg('reviews', 'rating')
                        ->orderByDesc('reviews_avg_rating');
                    break;
                case 'date':
                    $query->orderByDesc('created_at');
                    break;
                case 'title':
                    $query->orderBy('title');
                    break;
            }
        }

        // Apply search if requested
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                ->orWhereHas('author', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $books = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $books,
            'message' => 'Books retrieved successfully'
        ]);
    }

    /**
     * Store a newly created book
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_ids' => 'array|exists:genres,id'
        ]);

        $book = Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id
        ]);

        // Attach genres if provided
        if ($request->has('genre_ids')) {
            $book->genres()->attach($request->genre_ids);
        }

        $book->load(['author', 'genres']);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book created successfully'
        ], 201);
    }

    /**
     * Display the specified book
     */
    public function show(Book $book): JsonResponse
    {
        $book->load(['author', 'genres', 'reviews']);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book retrieved successfully'
        ]);
    }

    /**
     * Update the specified book
     */
    public function update(Request $request, Book $book): JsonResponse
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'genre_ids' => 'sometimes|array|exists:genres,id'
        ]);

        $book->update($request->only(['title', 'author_id']));

        // Update genres if provided
        if ($request->has('genre_ids')) {
            $book->genres()->sync($request->genre_ids);
        }

        $book->load(['author', 'genres']);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book updated successfully'
        ]);
    }

    /**
     * Remove the specified book
     */
    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully'
        ]);
    }

    /**
     * Get books by author
     */
    public function byAuthor(Author $author): JsonResponse
    {
        $books = $author->books()->with(['genres', 'reviews'])->get();

        return response()->json([
            'success' => true,
            'data' => $books,
            'author' => $author,
            'message' => 'Books by author retrieved successfully'
        ]);
    }

    /**
     * Get books by genre
     */
    public function byGenre(Genre $genre): JsonResponse
    {
        $books = $genre->books()->with(['author', 'reviews'])->get();

        return response()->json([
            'success' => true,
            'data' => $books,
            'genre' => $genre,
            'message' => 'Books by genre retrieved successfully'
        ]);
    }
}
