@extends('layouts.app')

@section('content')
<h1>Authors</h1>
<a href="{{ route('authors.create') }}" class="btn btn-primary mb-3">Add New Author</a>

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
        @foreach($authors as $author)
        <tr>
            <td>{{ $author->name }}</td>
            <td>{{ $author->books_count }}</td>
            <td>
                <a href="{{ route('authors.show', $author->id) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('authors.destroy', $author->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $authors->links() }}
@endsection