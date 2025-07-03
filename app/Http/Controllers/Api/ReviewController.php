<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews
     */
    public function index(Request $request): JsonResponse
    {
        $query = Review::with(['book.author']);

        // Filter by book if requested
        if ($request->has('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        // Filter by rating if requested
        if ($request->has('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $reviews,
            'message' => 'Reviews retrieved successfully'
        ]);
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000'
        ]);

        $review = Review::create([
            'book_id' => $request->book_id,
            'rating' => $request->rating,
            'content' => $request->content
        ]);

        $review->load(['book.author']);

        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review created successfully'
        ], 201);
    }

    /**
     * Display the specified review
     */
    public function show(Review $review): JsonResponse
    {
        $review->load(['book.author']);

        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review retrieved successfully'
        ]);
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, Review $review): JsonResponse
    {
        $request->validate([
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'content' => 'sometimes|required|string|max:1000'
        ]);

        $review->update($request->only(['rating', 'content']));
        $review->load(['book.author']);

        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review updated successfully'
        ]);
    }

    /**
     * Remove the specified review
     */
    public function destroy(Review $review): JsonResponse
    {
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }

    /**
     * Get reviews for a specific book
     */
    public function byBook(Book $book): JsonResponse
    {
        $reviews = $book->reviews()->latest()->get();
        $averageRating = $reviews->avg('rating');

        return response()->json([
            'success' => true,
            'data' => $reviews,
            'book' => $book->load('author'),
            'average_rating' => round($averageRating, 1),
            'total_reviews' => $reviews->count(),
            'message' => 'Book reviews retrieved successfully'
        ]);
    }
}
