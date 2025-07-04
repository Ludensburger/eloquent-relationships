<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Libretto</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('books.index') }}">Books</a>
                <a class="nav-link" href="{{ route('authors.index') }}">Authors</a>
                <a class="nav-link" href="{{ route('genres.index') }}">Genres</a>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        @yield('content')
    </div>
</body>

</html>