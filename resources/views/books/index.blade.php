@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="display-5 fw-bold text-primary">📖 Books Library</h1>
        <p class="text-muted">Explore and manage your book collection</p>
    </div>
    <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-plus"></i> Add New Book
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Filters & Stats -->
<div class="row mb-4">
    <div class="col-lg-8">
        <form method="GET" action="{{ route('books.index') }}" class="d-flex gap-2">
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="">🔄 Sort Books</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>⭐ By Rating</option>
                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>📅 By Date</option>
            </select>
            <button class="btn btn-outline-primary" type="submit">
                <i class="fas fa-filter"></i> Apply
            </button>
        </form>
    </div>
    <div class="col-lg-4">
        <div class="card bg-light border-0">
            <div class="card-body text-center py-3">
                <h6 class="card-title mb-2 text-muted">Library Average</h6>
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-star text-warning me-2"></i>
                    <span class="h5 mb-0 fw-bold text-primary">
                        {{ number_format($books->flatMap(function($book) { return $book->reviews; })->avg('rating') ?? 0, 1) }}
                    </span>
                    <small class="text-muted ms-1">/5.0</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Books Grid -->
<div class="row">
    @foreach($books as $book)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0" style="transition: all 0.3s ease;">
            <div class="card-body d-flex flex-column">
                <!-- Book Header -->
                <div class="mb-3">
                    <h5 class="card-title fw-bold text-primary mb-2">{{ $book->title }}</h5>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-user text-muted me-2"></i>
                        <a href="{{ route('authors.show', $book->author->id) }}" class="text-decoration-none text-secondary">
                            {{ $book->author->name }}
                        </a>
                    </div>
                </div>

                <!-- Genres -->
                <div class="mb-3">
                    @foreach($book->genres as $genre)
                    <a href="{{ route('genres.show', $genre->id) }}" class="text-decoration-none">
                        <span class="badge bg-light text-dark border me-1">{{ $genre->name }}</span>
                    </a>
                    @endforeach
                </div>

                <!-- Stats -->
                <div class="mb-3">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="text-muted small">Reviews</div>
                                <div class="fw-bold">{{ $book->reviews->count() }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Rating</div>
                            <div class="fw-bold text-warning">
                                <i class="fas fa-star"></i>
                                {{ number_format($book->reviews->avg('rating') ?? 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-auto">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($books->isEmpty())
<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-book-open text-muted" style="font-size: 4rem;"></i>
    </div>
    <h3 class="text-muted">No Books Found</h3>
    <p class="text-muted mb-4">Start building your library by adding your first book.</p>
    <a href="{{ route('books.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add First Book
    </a>
</div>
@endif

<div class="d-flex justify-content-center mt-4">
    {{ $books->links() }}
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection