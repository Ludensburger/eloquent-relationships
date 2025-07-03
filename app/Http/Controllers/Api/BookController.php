<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['author', 'genres', 'reviews'])->get();

        return response()->json([
            'message' => 'Books retrieved successfully',
            'data' => $books
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_ids' => 'array',
            'genre_ids.*' => 'exists:genres,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

        // Attach genres if provided
        if ($request->has('genre_ids')) {
            $book->genres()->attach($request->genre_ids);
        }

        $book->load(['author', 'genres', 'reviews']);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['author', 'genres', 'reviews']);

        return response()->json([
            'message' => 'Book retrieved successfully',
            'data' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'genre_ids' => 'array',
            'genre_ids.*' => 'exists:genres,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $book->update($request->only(['title', 'author_id']));

        // Sync genres if provided
        if ($request->has('genre_ids')) {
            $book->genres()->sync($request->genre_ids);
        }

        $book->load(['author', 'genres', 'reviews']);

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }
}
