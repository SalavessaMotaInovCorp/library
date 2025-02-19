<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Facades\Http;

class GoogleBooksService
{
    private const BASE_URL = "https://www.googleapis.com/books/v1/volumes";

    public function searchBooks($query)
    {
        $response = Http::get(self::BASE_URL, [
            'q' => $query,
            'maxResults' => 20,
            'orderBy' => 'relevance',
        ]);

        if ($response->successful()) {
            return $this->transformBooks($response->json()['items'] ?? []);
        }

        return collect();
    }

    private function transformBooks($books)
    {
        return collect($books)->map(function ($bookData) {
            $volumeInfo = $bookData['volumeInfo'] ?? [];
            $isbn = $this->extractISBN($volumeInfo['industryIdentifiers'] ?? []);
            if (!$isbn) {
                return null;
            }

            $existingBook = Book::where('isbn', $isbn)->first();
            if ($existingBook) {
                $existingBook->exists_in_db = true;
                return $existingBook;
            }


            $book = new Book();
            $book->isbn = $isbn;
            $book->name = $volumeInfo['title'] ?? 'Unknown Title';
            $book->description = $volumeInfo['description'] ?? 'No description available.';
            $book->cover_image = isset($volumeInfo['imageLinks']['thumbnail'])
                ? str_replace('&zoom=1', '&zoom=10', $volumeInfo['imageLinks']['thumbnail'])
                : null;

            $book->price = 0;

            $publisherName = $volumeInfo['publisher'] ?? 'Unknown Publisher';
            $publisher = Publisher::where('name', $publisherName)->first();
            if (!$publisher) {
                $publisher = new Publisher([
                    'name' => $publisherName
                ]);
            }
            $book->setRelation('publisher', $publisher);

            $authors = collect();
            if (!empty($volumeInfo['authors'])) {
                foreach ($volumeInfo['authors'] as $authorName) {
                    $author = Author::where('name', $authorName)->first();
                    if (!$author) {
                        $author = new Author([
                            'name' => $authorName,
                            ]);
                    }
                    $authors->push($author);
                }
            }
            $book->setRelation('authors', $authors);

            return $book;
        })->filter();
    }

    private function extractISBN($identifiers)
    {
        if (!empty($identifiers)) {
            foreach ($identifiers as $id) {
                if ($id['type'] === 'ISBN_13') {
                    return $id['identifier'];
                }
            }
            return $identifiers[0]['identifier'] ?? null;
        }
        return null;
    }
}
