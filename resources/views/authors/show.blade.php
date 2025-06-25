@extends('layouts.app')

@section('content')
<!-- Author Header -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white border-0 shadow">
            <div class="card-body p-5">
                <div class="d-flex align-items-center">
                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 80px; height: 80px; font-size: 2.5rem; font-weight: bold;">
                        {{ substr($author->name, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="display-4 fw-bold mb-2">{{ $author->name }}</h1>
                        <p class="fs-5 mb-3 opacity-75">
                            <i class="fas fa-user-edit me-2"></i>Author
                        </p>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-white text-primary fs-6 me-3">
                                <i class="fas fa-book me-1"></i>
                                {{ $author->books->count() }} {{ Str::plural('Book', $author->books->count()) }}
                            </span>
                            @if($author->books->count() > 0)
                            <span class="badge bg-light text-primary fs-6">
                                <i class="fas fa-star me-1"></i>
                                {{ number_format($author->books->flatMap->reviews->avg('rating') ?? 0, 1) }} Avg Rating
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
    <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Authors
    </a>
    <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Edit Author
    </a>
</div>

<!-- Books Section -->
@if($author->books->count() > 0)
<div class="mb-5">
    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-0">
            <i class="fas fa-books me-2"></i>Books by {{ $author->name }}
        </h3>
        <span class="ms-3 badge bg-primary">{{ $author->books->count() }}</span>
    </div>

    <div class="row">
        @foreach($author->books as $book)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0" style="transition: all 0.3s ease;">
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <h5 class="card-title fw-bold text-primary mb-2">{{ $book->title }}</h5>
                        <div class="mb-2">
                            @foreach($book->genres as $genre)
                            <span class="badge bg-light text-dark border me-1">{{ $genre->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">
                                <i class="fas fa-star text-warning"></i>
                                {{ number_format($book->reviews->avg('rating') ?? 0, 1) }}
                                ({{ $book->reviews->count() }} reviews)
                            </small>
                        </div>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary btn-sm w-100">
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
    <p class="text-muted mb-4">This author doesn't have any books in the library yet.</p>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add a Book
    </a>
</div>
@endif

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .badge {
        font-size: 0.875rem;
    }
</style>
@endsection