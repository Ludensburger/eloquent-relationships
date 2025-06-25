@extends('layouts.app')

@section('content')
<h1>Genres</h1>
<a href="{{ route('genres.create') }}" class="btn btn-primary mb-3">Add New Genre</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <th>Books Count</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($genres as $genre)
        <tr>
            <td>{{ $genre->name }}</td>
            <td>{{ $genre->books_count }}</td>
            <td>
                <a href="{{ route('genres.show', $genre->id) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $genres->links() }}
@endsection