@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="card shadow border-0">
            <div class="card-body p-5">
                <h2 class="fw-bold text-primary mb-4">
                    <i class="fas fa-user-plus me-2"></i>Add New Author
                </h2>
                <form action="{{ route('authors.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            <i class="fas fa-user"></i> Author Name
                        </label>
                        <input type="text"
                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter author's full name"
                            required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Add Author
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection