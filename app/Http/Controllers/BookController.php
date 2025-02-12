<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Display a paginated list of books
    public function index(Request $request)
    {
        $books = Book::latest()->paginate(10);
        return view('books.index', compact('books'));
    }

    // Show details of a specific book
    public function show(Book $book)
    {
        $authors = $book->authors;
        $book_requests = $book->bookRequests();

        $user = auth()->user();

        $hasActiveRequest = $user->bookRequests()
            ->where('book_id', $book->id)
            ->whereIn('status', ['active', 'pending_return_confirm'])
            ->exists();

        $isBookRequestedByOthers = $book->bookRequests()
            ->whereIn('status', ['active', 'pending_return_confirm'])
            ->where('user_id', '!=', $user->id)
            ->exists();

        return view('books.show', compact('book', 'authors', 'book_requests', 'hasActiveRequest', 'isBookRequestedByOthers'));
    }


    // Show the form to create a new book
    public function create(Request $request)
    {
        $publishers = Publisher::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();
        $selectedAuthors = $request->get('authors', []);

        return view('books.create', compact('publishers', 'authors', 'selectedAuthors'));
    }

    // Store a new book in the database
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

        // Attach authors to the book
        $book->authors()->attach(request()->authors);

        return redirect('/books');
    }

    // Show the form to edit an existing book
    public function edit(Book $book)
    {
        $publishers = Publisher::orderBy('name')->get();
        $authors = Author::orderBy('name')->get();
        $bookAuthorsIds = $book->authors->pluck('id')->toArray();

        return view('books.edit', compact('book', 'publishers', 'authors', 'bookAuthorsIds'));
    }

    // Update book details
    public function update(Book $book)
    {
        request()->validate([
            // ISBN must be exactly 10 or 13 digits
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

        // Sync authors with the book
        $book->authors()->sync(request()->authors);

        return redirect('/books/' . $book->id);
    }

    // Delete a book from the database
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }


}
