<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['book'])->get();

        return response()->json([
            'message' => 'Reviews retrieved successfully',
            'data' => $reviews
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $review = Review::create([
            'book_id' => $request->book_id,
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        $review->load(['book']);

        return response()->json([
            'message' => 'Review created successfully',
            'data' => $review
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load(['book']);

        return response()->json([
            'message' => 'Review retrieved successfully',
            'data' => $review
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'sometimes|required|exists:books,id',
            'content' => 'sometimes|required|string',
            'rating' => 'sometimes|required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $review->update($request->only(['book_id', 'content', 'rating']));
        $review->load(['book']);

        return response()->json([
            'message' => 'Review updated successfully',
            'data' => $review
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully'
        ]);
    }
}
