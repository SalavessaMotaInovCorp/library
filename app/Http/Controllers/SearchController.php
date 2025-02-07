<?php

namespace App\Http\Controllers;

use App\Models\Book;

class SearchController extends Controller
{
    // Handle search requests for books
    public function __invoke()
    {
        $books = Book::with(['authors', 'publisher']) // Eager load authors and publisher
        ->where('name', 'like', '%' . request('query') . '%') // Filter books by name
        ->paginate(10); // Paginate results

        return view('results', compact('books'));
    }
}
