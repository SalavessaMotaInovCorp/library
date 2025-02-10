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

// Public route for the home page
Route::get('/', [HomeController::class, 'index']);

// Public route for search functionality
Route::get('/search', SearchController::class);


Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers.index');

// Protected routes (require authentication)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])
        ->name('dashboard'); // Dashboard route

    // Export books to Excel
    Route::get('/books/export', function () {
        return Excel::download(new BooksExport, 'books.xlsx');
    })->middleware('role:admin')
        ->name('books.export');

    Route::get('/books/create', [BookController::class, 'create'])->name('books.create')->middleware('role:admin');

    // Resource routes for books
    Route::resource('books', BookController::class)
        ->except('index')
        ->middleware('role:admin');

    // Export authors to Excel
    Route::get('/authors/export', function () {
        return Excel::download(new AuthorsExport, 'authors.xlsx');
    })
        ->middleware('role:admin')
        ->name('authors.export');

    Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create')->middleware('role:admin');
    // Resource routes for authors
    Route::resource('authors', AuthorController::class)
        ->except('index')
        ->middleware('role:admin');

    // Export publishers to Excel
    Route::get('/publishers/export', function () {
        return Excel::download(new PublishersExport, 'publishers.xlsx');
    })
        ->middleware('role:admin')
        ->name('publishers.export');

    Route::get('/publishers/create', [PublisherController::class, 'create'])->name('publishers.create')->middleware('role:admin');

    // Resource routes for publishers
    Route::resource('publishers', PublisherController::class)
        ->except('index')
        ->middleware('role:admin');
});


