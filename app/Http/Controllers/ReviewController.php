<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;

class ReviewController extends Controller
{
    public function create()
    {
        $books = Book::all();
        return view('reviews.create', compact('books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        Review::create([
            'book_id' => $request->book_id,
            'rating' => $request->rating,
            'content' => $request->content,
        ]);

        return redirect()->route('books.show', $request->book_id)
            ->with('success', 'Review added successfully!');
    }
}
