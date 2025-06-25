@extends('layouts.app')

@section('content')
<!-- Book Header -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white border-0 shadow">
            <div class="card-body p-5">
                <div class="d-flex align-items-start">
                    <div class="bg-white text-primary rounded d-flex align-items-center justify-content-center me-4" style="width: 100px; height: 140px; font-size: 3rem;">
                        📖
                    </div>
                    <div class="flex-grow-1">
                        <h1 class="display-4 fw-bold mb-3">{{ $book->title }}</h1>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-user me-2"></i>
                            <span class="fs-5">by
                                <a href="{{ route('authors.show', $book->author->id) }}" class="text-white text-decoration-underline">
                                    {{ $book->author->name }}
                                </a>
                            </span>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach($book->genres as $genre)
                            <a href="{{ route('genres.show', $genre->id) }}" class="text-decoration-none">
                                <span class="badge bg-white text-primary fs-6">{{ $genre->name }}</span>
                            </a>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star text-warning me-2 fs-4"></i>
                                    <div>
                                        <div class="h4 mb-0">{{ number_format($book->reviews->avg('rating') ?? 0, 1) }}</div>
                                        <small class="opacity-75">Average Rating</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-comments text-warning me-2 fs-4"></i>
                                    <div>
                                        <div class="h4 mb-0">{{ $book->reviews->count() }}</div>
                                        <small class="opacity-75">{{ Str::plural('Review', $book->reviews->count()) }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Books
    </a>
    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">
        <i class="fas fa-edit me-2"></i>Edit Book
    </a>
</div>

<!-- Reviews Section -->
@if($book->reviews->count() > 0)
<div class="mb-5">
    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-0">
            <i class="fas fa-star me-2"></i>Reviews & Ratings
        </h3>
        <span class="ms-3 badge bg-primary">{{ $book->reviews->count() }}</span>
    </div>

    <div class="row">
        @foreach($book->reviews as $review)
        <div class="col-lg-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Anonymous Reviewer</h6>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="d-flex align-items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                            </div>
                            <small class="text-muted">{{ $review->rating }}/5</small>
                        </div>
                    </div>
                    <p class="card-text">{{ $review->review_text }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<!-- No Reviews State -->
<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-comment-alt text-muted" style="font-size: 4rem;"></i>
    </div>
    <h3 class="text-muted mb-3">No Reviews Yet</h3>
    <p class="text-muted mb-4">Be the first to share your thoughts about this book!</p>
    <button class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add First Review
    </button>
</div>
@endif

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
</style>
@endsection