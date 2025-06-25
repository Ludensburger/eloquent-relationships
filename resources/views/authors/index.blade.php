@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="display-5 fw-bold text-primary">📚 Authors</h1>
        <p class="text-muted">Discover and manage your favorite authors</p>
    </div>
    <a href="{{ route('authors.create') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-plus"></i> Add New Author
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    @foreach($authors as $author)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0" style="transition: transform 0.2s;">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 1.5rem;">
                        {{ substr($author->name, 0, 1) }}
                    </div>
                    <div>
                        <h5 class="card-title mb-1 fw-bold">{{ $author->name }}</h5>
                        <small class="text-muted">Author</small>
                    </div>
                </div>

                <div class="mb-3">
                    <span class="badge bg-light text-dark border">
                        <i class="fas fa-book"></i> {{ $author->books_count }} {{ Str::plural('Book', $author->books_count) }}
                    </span>
                </div>

                <div class="mt-auto">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('authors.show', $author->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('authors.destroy', $author->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this author?')">
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

@if($authors->isEmpty())
<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-user-edit text-muted" style="font-size: 4rem;"></i>
    </div>
    <h3 class="text-muted">No Authors Found</h3>
    <p class="text-muted mb-4">Start by adding your first author to the library.</p>
    <a href="{{ route('authors.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add First Author
    </a>
</div>
@endif

<div class="d-flex justify-content-center mt-4">
    {{ $authors->links() }}
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection