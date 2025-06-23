@extends('layouts.app')

@section('content')
<h1>Add New Book</h1>

@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
    {{ $error }}<br>
    @endforeach
</div>
@endif

<form method="POST" action="{{ route('books.store') }}">
    @csrf
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Author</label>
        <select name="author_id" class="form-control" required>
            @foreach($authors as $author)
            <option value="{{ $author->id }}">{{ $author->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Genres</label>
        <select name="genre_ids[]" class="form-control" multiple required>
            @foreach($genres as $genre)
            <option value="{{ $genre->id }}"
                {{ (isset($book) && $book->genres->contains($genre->id)) ? 'selected' : '' }}>
                {{ $genre->name }}
            </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary">Save</button>
</form>
@endsection