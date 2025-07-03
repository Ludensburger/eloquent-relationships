<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    /**
     * Display a listing of genres
     */
    public function index(Request $request): JsonResponse
    {
        $query = Genre::withCount('books');

        // Apply search if requested
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $genres = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $genres,
            'message' => 'Genres retrieved successfully'
        ]);
    }

    /**
     * Store a newly created genre
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name'
        ]);

        $genre = Genre::create([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre created successfully'
        ], 201);
    }

    /**
     * Display the specified genre
     */
    public function show(Genre $genre): JsonResponse
    {
        $genre->load('books.author');
        $genre->loadCount('books');

        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre retrieved successfully'
        ]);
    }

    /**
     * Update the specified genre
     */
    public function update(Request $request, Genre $genre): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id
        ]);

        $genre->update([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre updated successfully'
        ]);
    }

    /**
     * Remove the specified genre
     */
    public function destroy(Genre $genre): JsonResponse
    {
        // Check if genre has books
        if ($genre->books()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete genre with existing books'
            ], 422);
        }

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Genre deleted successfully'
        ]);
    }
}
