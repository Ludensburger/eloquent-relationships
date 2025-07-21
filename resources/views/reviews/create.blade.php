@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card shadow border-0">
            <div class="card-body p-5">
                <h2 class="fw-bold text-primary mb-4">
                    <i class="fas fa-star me-2"></i>Add a Review
                </h2>
                <form method="POST" action="{{ route('reviews.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="book_id" class="form-label fw-semibold">Select Book</label>
                        <select name="book_id" id="book_id" class="form-select" required>
                            <option value="">Choose a book...</option>
                            @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="rating" class="form-label fw-semibold">Rating</label>
                        <div class="d-flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" class="btn-check" name="rating" id="star{{ $i }}" value="{{ $i }}" autocomplete="off" required>
                                <label class="btn btn-outline-warning" for="star{{ $i }}">
                                    <i class="fas fa-star"></i> {{ $i }}
                                </label>
                                @endfor
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="content" class="form-label fw-semibold">Review</label>
                        <textarea name="content" id="content" class="form-control" rows="4" required placeholder="Share your thoughts..."></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .btn-check:checked+.btn-outline-warning {
        background-color: #ffc107;
        color: #fff;
        border-color: #ffc107;
    }
</style>
@endsection