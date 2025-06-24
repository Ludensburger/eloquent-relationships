@extends('layouts.app')

@section('content')
<h1>Edit Genre</h1>

<form action="{{ route('genres.update', $genre->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $genre->name) }}" required>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update Genre</button>
    <a href="{{ route('genres.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection