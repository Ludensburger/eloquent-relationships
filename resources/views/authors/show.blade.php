@extends('layouts.app')

@section('content')
<h1>{{ $author->name }}</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Author Details</h5>
        <p class="card-text"><strong>Books Count:</strong> {{ $author->books->count() }}</p>
    </div>
</div>

@if($author->books->count() > 0)
<h3 class="mt-4">Books by this Author</h3>
<div class="row">
    @foreach($author->books as $book)
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $book->title }}</h5>
                <p class="card-text">
                    <strong>Genres:</strong>
                    @foreach($book->genres as $genre)
                    {{ $genre->name }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </p>
                <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary btn-sm">View Book</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<a href="{{ route('authors.index') }}" class="btn btn-secondary mt-3">Back to Authors</a>
<a href="{{ route('authors.edit', $author->id) }}" class="btn btn-warning mt-3">Edit Author</a>
@endsection