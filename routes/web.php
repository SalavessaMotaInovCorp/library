<?php

use App\Exports\AuthorsExport;
use App\Exports\BooksExport;
use App\Exports\PublishersExport;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

// Protected routes (require authentication)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard'); // Dashboard route

    // Export books to Excel
    Route::get('/books/export', function () {
        return Excel::download(new BooksExport, 'books.xlsx');
    })->name('books.export');

    // Resource routes for books
    Route::resource('books', BookController::class);

    // Export authors to Excel
    Route::get('/authors/export', function () {
        return Excel::download(new AuthorsExport, 'authors.xlsx');
    })->name('authors.export');

    // Resource routes for authors
    Route::resource('authors', AuthorController::class);

    // Export publishers to Excel
    Route::get('/publishers/export', function () {
        return Excel::download(new PublishersExport, 'publishers.xlsx');
    })->name('publishers.export');

    // Resource routes for publishers
    Route::resource('publishers', PublisherController::class);
});

// Public route for the home page
Route::get('/', [HomeController::class, 'index']);

// Public route for search functionality
Route::get('/search', SearchController::class);
