<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'books_count' => Book::count(),
            'authors_count' => Author::count(),
            'publishers_count' => Publisher::count(),
            'recent_books' => Book::latest()->take(8)->get(),
        ]);
    }

    public function dashboard()
    {
        return view('dashboard', [
            'books_count' => Book::count(),
            'authors_count' => Author::count(),
            'publishers_count' => Publisher::count(),
            'recent_books' => Book::latest()->take(8)->get(),
        ]);
    }
}
