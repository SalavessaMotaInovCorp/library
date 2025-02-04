<?php

namespace App\Http\Controllers;

use App\Models\Book;

class SearchController extends Controller
{
    public function __invoke()
    {


        $books = Book::query()
            ->with(['authors', 'publisher'])
            ->where('name', 'like', '%' . request('query') . '%')
            ->paginate(10);

        return view ('results', ['books' => $books]);
    }
}
