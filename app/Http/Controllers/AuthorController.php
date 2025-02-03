<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::with('books')->latest()->paginate(10);

        return view('authors.index', [
            'authors' => $authors
        ]);
    }
}
