@extends('layouts.app')

@section('content')
<h1>Add New Author</h1>

<form action="{{ route('authors.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Add Author</button>
    <a href="{{ route('authors.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection