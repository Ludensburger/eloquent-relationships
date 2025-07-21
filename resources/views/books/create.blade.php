@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card shadow border-0">
            <div class="card-body p-5">
                <h2 class="fw-bold text-primary mb-4">
                    <i class="fas fa-book-medical me-2"></i>Add New Book
                </h2>
                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                    {{ $error }}<br>
                    @endforeach
                </div>
                @endif
                <form method="POST" action="{{ route('books.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Author</label>
                        <select name="author_id" class="form-select" required>
                            @foreach($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Genres</label>
                        <select name="genre_ids[]" class="form-select" multiple required>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}"
                                {{ (isset($book) && $book->genres->contains($genre->id)) ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection