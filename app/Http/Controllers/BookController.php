<?php

namespace App\Http\Controllers;


use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with(['author', 'genres', 'reviews']);

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'rating':
                    // sort by avg rating DESC
                    $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                    break;
                case 'date':
                    // latest first
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    // fallback (optional)
                    break;
            }
        }

        $books = $query->paginate(10);
        return view('books.index', compact('books'));
    }
    /**
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $authors = Author::all();
        $genres = Genre::all();
        
        // Pre-select author or genre if coming from their pages
        $selectedAuthor = $request->get('author_id');
        $selectedGenre = $request->get('genre_id');
        
        return view('books.create', compact('authors', 'genres', 'selectedAuthor', 'selectedGenre'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author_id' => 'required|exists:authors,id',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

        $book->genres()->sync($request->genre_ids);

        return redirect()->route('books.index')->withSuccess('Book added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with(['author', 'genre', 'reviews'])->findOrFail($id);
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $genres = Genre::all();
        return view('books.edit', compact('book', 'authors', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'author_id' => 'required|exists:authors,id',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $book = Book::findOrFail($id);
        $book->update([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

        $book->genres()->sync($request->genre_ids);

        return redirect()->route('books.index')->withSuccess('Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Book::destroy($id);
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
