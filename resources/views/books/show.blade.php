@extends('layouts.app')

@section('content')
<h1>Book Details</h1>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">{{ $book->title }}</h3>
        <p><strong>Author:</strong> {{ $book->author->name }}</p>
        <p><strong>Genres:</strong>
            @foreach($book->genres as $genre)
            {{ $genre->name }}{{ !$loop->last ? ', ' : '' }}
            @endforeach
        </p>
        <p><strong>Total Reviews:</strong> {{ $book->reviews->count() }}</p>
        <p><strong>Average Rating:</strong> {{ number_format($book->reviews->avg('rating'), 2) }}</p>
        <h5>Reviews:</h5>
        <ul>
            @foreach($book->reviews as $review)
            <li>{{ $review->review_text }} — Rating: {{ $review->rating }}</li>
            @endforeach
        </ul>
    </div>
</div>

<a href="{{ route('books.index') }}" class="btn btn-secondary mt-3">Back to List</a>
@endsection