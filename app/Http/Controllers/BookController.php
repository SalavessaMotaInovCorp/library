<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('publisher')->latest()->Paginate(20);

        return view('books.index', [
            'books' => $books
        ]);
    }

    public function show(Book $book)
    {
        return view('books.show', ['book' => $book]);
    }

    public function create()
    {
        $publishers = Publisher::all();
        return view('books.create', compact('publishers'));
    }

    public function store()
    {
        request()->validate([
            'isbn' => ['required', 'regex:/^(?:\d{10}|\d{13})$/'],
            'name' => ['required', 'min:3'],
            'publisher_id' => 'required|exists:publishers,id',
            'description' => ['required', 'min:3'],
            'cover_image' => ['required', 'min:5'],
            'price' => 'required|numeric|min:0',
        ]);

        Book::create([
            'isbn' => request('isbn'),
            'name' => request('name'),
            'publisher_id' => request('publisher_id'),
            'description' => request('description'),
            'cover_image' => request('cover_image'),
            'price' => request('price'),
        ]);

        return redirect('/books');
    }

    public function edit(Book $book)
    {
        $publishers = Publisher::all();

        return view('books.edit', compact('book', 'publishers'));
    }


    public function update (Book $book)
    {
        request()->validate([
            // isbn number has to have exactly 10 or 13 digits
            'isbn' => ['required', 'regex:/^(?:\d{10}|\d{13})$/'],
            'name' => ['required', 'min:3'],
            'publisher_id' => 'required|exists:publishers,id',
            'description' => ['required', 'min:3'],
            'cover_image' => ['required', 'min:5'],
            'price' => ['required', 'numeric'],
        ]);


        $book->update([
            'isbn' => request('isbn'),
            'name' => request('name'),
            'publisher_id' => request('publisher_id'),
            'description' => request('description'),
            'cover_image' => request('cover_image'),
            'price' => request('price')
        ]);

        return redirect('/books/' . $book->id);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }
}
