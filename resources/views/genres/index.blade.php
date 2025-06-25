@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="display-5 fw-bold text-primary">🏷️ Genres</h1>
        <p class="text-muted">Explore books by category and genre</p>
    </div>
    <a href="{{ route('genres.create') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-plus"></i> Add New Genre
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
    @foreach($genres as $genre)
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card h-100 shadow-sm border-0" style="transition: transform 0.2s;">
            <div class="card-body d-flex flex-column text-center">
                <div class="mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.8rem;">
                        🏷️
                    </div>
                    <h5 class="card-title fw-bold text-primary mb-2">{{ $genre->name }}</h5>
                </div>

                <div class="mb-3">
                    <span class="badge bg-light text-dark border fs-6">
                        <i class="fas fa-book"></i> {{ $genre->books_count }} {{ Str::plural('Book', $genre->books_count) }}
                    </span>
                </div>

                <div class="mt-auto">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('genres.show', $genre->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this genre?')">
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

@if($genres->isEmpty())
<div class="text-center py-5">
    <div class="mb-4">
        <i class="fas fa-tags text-muted" style="font-size: 4rem;"></i>
    </div>
    <h3 class="text-muted">No Genres Found</h3>
    <p class="text-muted mb-4">Start organizing your books by adding your first genre.</p>
    <a href="{{ route('genres.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add First Genre
    </a>
</div>
@endif

<div class="d-flex justify-content-center mt-4">
    {{ $genres->links() }}
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection