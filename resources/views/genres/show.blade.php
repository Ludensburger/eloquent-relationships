@extends('layouts.app')

@section('content')
<!-- Genre Header -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card bg-gradient-success text-white border-0 shadow">
            <div class="card-body p-5">
                <div class="d-flex align-items-center">
                    <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 80px; height: 80px; font-size: 2.5rem;">
                        🏷️
                    </div>
                    <div>
                        <h1 class="display-4 fw-bold mb-2">{{ $genre->name }}</h1>
                        <p class="fs-5 mb-3 opacity-75">
                            <i class="fas fa-tag me-2"></i>Genre Category
                        </p>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-white text-success fs-6 me-3">
                                <i class="fas fa-book me-1"></i>
                                {{ $genre->books->count() }} {{ Str::plural('Book', $genre->books->count()) }}
                            </span>
                            @if($genre->books->count() > 0)
                            <span class="badge bg-light text-success fs-6">
                                <i class="fas fa-star me-1"></i>
                                {{ number_format($genre->books->flatMap->reviews->avg('rating') ?? 0, 1) }} Avg Rating
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('genres.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Genres
    </a>
    <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Edit Genre
    </a>
</div>

<!-- Books Section -->
@if($genre->books->count() > 0)
<div class="mb-5">
    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold text-success mb-0">
            <i class="fas fa-books me-2"></i>Books in {{ $genre->name }}
        </h3>
        <span class="ms-3 badge bg-success">{{ $genre->books->count() }}</span>
    </div>

    <div class="row">
        @foreach($genre->books as $book)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0" style="transition: all 0.3s ease;">
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <h5 class="card-title fw-bold text-success mb-2">{{ $book->title }}</h5>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-user text-muted me-2"></i>
                            <a href="{{ route('authors.show', $book->author->id) }}" class="text-decoration-none text-secondary">
                                {{ $book->author->name }}
                            </a>
                        </div>

                        @if($book->genres->where('id', '!=', $genre->id)->count() > 0)
                        <div class="mb-2">
                            <small class="text-muted">Other genres:</small><br>
                            @foreach($book->genres->where('id', '!=', $genre->id) as $otherGenre)
                            <span class="badge bg-light text-dark border me-1">{{ $otherGenre->name }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">
                                <i class="fas fa-star text-warning"></i>
                                {{ number_format($book->reviews->avg('rating') ?? 0, 1) }}
                                ({{ $book->reviews->count() }} reviews)
                            </small>
                        </div>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-success btn-sm w-100">
                            <i class="fas fa-eye me-2"></i>View Book Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<!-- No Books State -->
<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-book-open text-muted" style="font-size: 4rem;"></i>
    </div>
    <h3 class="text-muted mb-3">No Books Found</h3>
    <p class="text-muted mb-4">No books have been assigned to this genre yet.</p>
    <a href="{{ route('books.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Add a Book
    </a>
</div>
@endif

<style>
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection