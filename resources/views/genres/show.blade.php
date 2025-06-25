@extends('layouts.app')

@section('content')
<h1>{{ $genre->name }}</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Genre Details</h5>
        <p class="card-text"><strong>Books Count:</strong> {{ $genre->books->count() }}</p>
    </div>
</div>

@if($genre->books->count() > 0)
<h3 class="mt-4">Books in this Genre</h3>
<div class="row">
    @foreach($genre->books as $book)
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $book->title }}</h5>
                <p class="card-text"><strong>Author:</strong> {{ $book->author->name }}</p>
                <p class="card-text">
                    <strong>Other Genres:</strong>
                    @foreach($book->genres->where('id', '!=', $genre->id) as $otherGenre)
                    {{ $otherGenre->name }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </p>
                <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary btn-sm">View Book</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<a href="{{ route('genres.index') }}" class="btn btn-secondary mt-3">Back to Genres</a>
<a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-warning mt-3">Edit Genre</a>
@endsection