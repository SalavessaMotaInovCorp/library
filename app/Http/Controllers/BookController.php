<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::latest()->paginate(10);

        return view('books.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('books.show', [
            'book' => $book,
            'authors' => $book->authors()->get()
            ]);
    }

    public function create()
    {
        $publishers = Publisher::orderBy('name', 'asc')->get();
        $authors = Author::orderBy('name', 'asc')->paginate(10);
        return view('books.create', compact('publishers', 'authors'));
    }


    public function store()
    {
        request()->validate([
            'isbn' => 'required|string|unique:books,isbn',
            'name' => 'required|string',
            'description' => 'required|string',
            'cover_image' => 'required|string',
            'price' => 'required|numeric',
            'publisher_id' => 'required|exists:publishers,id',
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
        ]);

        $book = Book::create([
            'isbn' => request('isbn'),
            'name' => request('name'),
            'publisher_id' => request('publisher_id'),
            'description' => request('description'),
            'cover_image' => request('cover_image'),
            'price' => request('price'),
        ]);

        $book->authors()->attach(request()->authors);

        return redirect('/books');
    }

    public function edit(Book $book)
    {
        $publishers = Publisher::orderBy('name', 'asc')->get();
        $authors = Author::orderBy('name', 'asc')->paginate(15);
        $bookAuthorsIds = $book->authors->pluck('id')->toArray();
        return view('books.edit', compact('book', 'publishers', 'authors', 'bookAuthorsIds'));
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

        $book->authors()->sync(request()->authors);

        return redirect('/books/' . $book->id);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }
}
