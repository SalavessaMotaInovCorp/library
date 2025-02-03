<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('publisher')->latest()->Paginate(10);

        return view('books.index', [
            'books' => $books
        ]);
    }
}
