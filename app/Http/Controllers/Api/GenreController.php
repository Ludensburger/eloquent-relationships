<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::with(['books'])->get();

        return response()->json([
            'message' => 'Genres retrieved successfully',
            'data' => $genres
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $genre = Genre::create([
            'name' => $request->name,
        ]);

        $genre->load(['books']);

        return response()->json([
            'message' => 'Genre created successfully',
            'data' => $genre
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        $genre->load(['books']);

        return response()->json([
            'message' => 'Genre retrieved successfully',
            'data' => $genre
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $genre->update($request->only(['name']));
        $genre->load(['books']);

        return response()->json([
            'message' => 'Genre updated successfully',
            'data' => $genre
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response()->json([
            'message' => 'Genre deleted successfully'
        ]);
    }
}
