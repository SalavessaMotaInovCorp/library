<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Services\GoogleBooksService;
use Illuminate\Http\Request;

class GoogleBooksController extends Controller
{
    protected $googleBooksService;

    public function __construct(GoogleBooksService $googleBooksService)
    {
        $this->googleBooksService = $googleBooksService;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $apiBooks = $this->googleBooksService->searchBooks($query);

        return view('books.google_results', [
            'apiBooks' => $apiBooks
        ]);
    }

    public function orderBook(Request $request)
    {
        $data = $request->all();

        $publisher = Publisher::where('name', $data['publisher'])->first();
        if (!$publisher) {
            $publisher = Publisher::create([
                'name' => $data['publisher'],
                'logo' => 'storage/publishers/default_publisher_logo.jpg'
            ]);
        }

        $book = Book::create([
            'isbn' => $data['isbn'],
            'name' => $data['title'],
            'description' => $data['description'],
            'cover_image' => $data['cover_image'],
            'price' => rand(1,50),
            'publisher_id' => $publisher->id,
        ]);

        $authorsArray = is_array($data['authors']) ? $data['authors'] : json_decode($data['authors'], true) ?? [];

        foreach ($authorsArray as $authorName) {
            $author = Author::where('name', $authorName)->first();

            if (!$author) {
                $author = Author::create([
                    'name' => $authorName,
                    'photo' => 'storage/authors/default_author_photo.jpg'
                ]);
            }

            if (!$book->authors()->where('authors.id', $author->id)->exists()) {
                $book->authors()->attach($author->id);
            }
        }

        return redirect()->back()->with('success', 'Book ordered successfully!');
    }

}
