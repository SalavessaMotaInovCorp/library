<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Display a paginated list of books
    public function index(Request $request)
    {
        return view('books.index');
    }


    public function getRelatedBooksFullText(Book $book)
    {
        $query = $book->name;

        if (empty($query)) {
            return collect([]);
        }

        $relatedBooks = Book::selectRaw("*, MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE) as relevance", [$query])
            ->where('id', '!=', $book->id)
            ->whereNotNull('name')
            ->having('relevance', '>', 0)
            ->orderByDesc('relevance')
            ->limit(4)
            ->get();

        return $relatedBooks;
    }

    // Show details of a specific book
    public function show(Book $book)
    {
        $authors = $book->authors;
        $book_requests = $book->bookRequests();
        $book_reviews = $book->bookReviews()->where('status', 'approved')->paginate(5);

        $hasActiveRequest = false;
        $isBookRequestedByOthers = false;

        if (Auth::check()) {
            $user = auth()->user();

            $hasActiveRequest = $user->bookRequests()
                ->where('book_id', $book->id)
                ->whereIn('status', ['active', 'pending_return_confirm'])
                ->exists();

            $isBookRequestedByOthers = $book->bookRequests()
                ->whereIn('status', ['active', 'pending_return_confirm'])
                ->where('user_id', '!=', $user->id)
                ->exists();

            $alreadyInCart = $user->cartItems()->where('book_id', $book->id)->exists();
        } else {
            $alreadyInCart = false;
        }

        $relatedBooks = $this->getRelatedBooksFullText($book);

        //$isSold = $book->orderItems()->exists();

        return view('books.show', compact(
            'book', 'authors', 'book_requests', 'book_reviews',
            'hasActiveRequest', 'isBookRequestedByOthers',
            'alreadyInCart', 'relatedBooks'
        ));
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
    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|string|unique:books,isbn',
            'name' => 'required|string',
            'description' => 'required|string',
            'cover_image' => 'required|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'price' => 'required|numeric',
            'publisher_id' => 'required|exists:publishers,id',
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
        ]);

        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('covers', 'public');
        } else {
            $imagePath = 'covers/default_cover.jpg';
        }

        $book = Book::create([
            'isbn' => $request->isbn,
            'name' => $request->name,
            'publisher_id' => $request->publisher_id,
            'description' => $request->description,
            'cover_image' => $imagePath,
            'price' => $request->price,
        ]);

        $book->authors()->attach($request->authors);

        return redirect('/books')->with('success', 'Book added successfully!');
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
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'isbn' => ['required', 'regex:/^(?:\d{10}|\d{13})$/'],
            'name' => ['required', 'min:3'],
            'publisher_id' => 'required|exists:publishers,id',
            'description' => ['required', 'min:3'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:12288'],
            'price' => ['required', 'numeric'],
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::delete('public/covers/' . $book->cover_image);
            }

            $imagePath = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $imagePath;
        }

        $book->update($validated);

        $book->authors()->sync($request->authors);

        return redirect()->route('books.show', $book->id)->with('success', 'Book updated successfully!');
    }

    // Delete a book from the database
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }

    public function markInterest(Book $book)
    {
        $user = auth()->user();

        if (!$book->interestedUsers()->where('user_id', $user->id)->exists()) {
            $book->interestedUsers()->attach($user->id);
            return back()->with('success', 'You will be notified when this book becomes available.');
        }

        return back()->with('warning', 'You are already registered to receive notifications for this book.');
    }



}
