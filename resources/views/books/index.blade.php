@extends('layouts.app')

@section('content')
<h1>Book List</h1>
<a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add New Book</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('books.index') }}" class="mb-3">
    <div class="input-group">
        <select name="sort" class="form-select" onchange="this.form.submit()">
            <option value="">-- Sort By --</option>
            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
            <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Newest</option>
        </select>
        <button class="btn btn-primary" type="submit">Sort</button>
    </div>
</form>
<!-- Display average rating for all books -->
<div class="mb-3">
    <strong>Average Rating (All Books):</strong>
    {{ number_format($books->flatMap(function($book) { return $book->reviews; })->avg('rating') ?? 0, 2) }}
</div>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Reviews</th>
            <th>Avg Rating</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author->name }}</td>
            <td>
                @foreach($book->genres as $genre)
                {{ $genre->name }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </td>
            <td>{{ $book->reviews->count() }}</td>
            <td>{{ number_format($book->reviews->avg('rating'), 2) }}</td>
            <td>
                <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this book?')" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $books->links() }}
</div>
@endsection