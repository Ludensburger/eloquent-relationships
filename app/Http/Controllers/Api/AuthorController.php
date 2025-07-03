<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    /**
     * Display a listing of authors
     */
    public function index(Request $request): JsonResponse
    {
        $query = Author::withCount('books');

        // Apply search if requested
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $authors = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $authors,
            'message' => 'Authors retrieved successfully'
        ]);
    }

    /**
     * Store a newly created author
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:authors,name'
        ]);

        $author = Author::create([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author created successfully'
        ], 201);
    }

    /**
     * Display the specified author
     */
    public function show(Author $author): JsonResponse
    {
        $author->load('books.genres');
        $author->loadCount('books');

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author retrieved successfully'
        ]);
    }

    /**
     * Update the specified author
     */
    public function update(Request $request, Author $author): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id
        ]);

        $author->update([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author updated successfully'
        ]);
    }

    /**
     * Remove the specified author
     */
    public function destroy(Author $author): JsonResponse
    {
        // Check if author has books
        if ($author->books()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete author with existing books'
            ], 422);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully'
        ]);
    }
}
