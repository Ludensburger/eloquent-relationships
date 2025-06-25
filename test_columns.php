<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Test if we can access the image columns
    $authors = DB::select('PRAGMA table_info(authors)');
    $books = DB::select('PRAGMA table_info(books)');

    echo "Authors table columns:\n";
    foreach ($authors as $column) {
        echo "- {$column->name} ({$column->type})\n";
    }

    echo "\nBooks table columns:\n";
    foreach ($books as $column) {
        echo "- {$column->name} ({$column->type})\n";
    }

    // Test if we can create a book with image
    echo "\nTesting book creation with image field...\n";
    $author = \App\Models\Author::first();
    $genre = \App\Models\Genre::first();

    if ($author && $genre) {
        $book = new \App\Models\Book();
        $book->title = 'Test Book with Image';
        $book->author_id = $author->id;
        $book->image = 'test_image.jpg';
        $book->save();
        $book->genres()->attach($genre->id);
        echo "✓ Successfully created book with image field!\n";
        echo "Book ID: {$book->id}, Image: {$book->image}\n";

        // Clean up
        $book->delete();
        echo "✓ Test book deleted\n";
    } else {
        echo "⚠ No authors or genres found for testing\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
