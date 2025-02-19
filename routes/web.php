<?php

use App\Exports\AuthorsExport;
use App\Exports\BookRequestsExport;
use App\Exports\BooksExport;
use App\Exports\PublishersExport;
use App\Exports\UsersExport;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\GoogleBooksController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;


// Home page
Route::get('/', [HomeController::class, 'index']);

// Search functionality
Route::get('/search', SearchController::class);

// Protected Routes (Authentication Required)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    // Dashboard route
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/book-requests', [BookRequestController::class, 'index'])->name('book_requests.index');
    Route::get('/book-requests/available', [BookRequestController::class, 'available'])->name('book_requests.available');
    Route::get('/book-requests/{book}/history', [BookRequestController::class, 'bookRequestsHistory'])->name('book_requests.history');
    Route::post('/book-requests/{book}/request', [BookRequestController::class, 'requestBook'])
        ->name('book_requests.request');
    Route::post('/book-requests/{bookRequest}/returnBook', [BookRequestController::class, 'returnBook'])
        ->name('book_requests.returnBook');
    Route::post('/book-requests/{bookRequest}/confirmReturn', [BookRequestController::class, 'confirmReturn'])
        ->name('book_requests.confirmReturn');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {

        // Administration Panel
        Route::get('/admin-panel', [HomeController::class, 'admin_panel'])->name('admin_panel');

        // Google / Main Warehouse Book Search and Order
        Route::get('/google-books/search', [GoogleBooksController::class, 'search'])->name('googlebooks.search');
        Route::post('/google-books/order', [GoogleBooksController::class, 'orderBook'])->name('google_books.order');

        // Export users to Excel
        Route::get('/admin-panel/export', function () {
            return Excel::download(new UsersExport, 'users.xlsx');
        })->name('admin-panel.export');

        Route::get('/book-requests-admin', [BookRequestController::class, 'indexAdmin'])->name('book_requests.index_admin');
        Route::get('/book-requests-admin/{user}', [BookRequestController::class, 'userBookRequestsForAdmin'])->name('book_requests.userBookRequestsForAdmin');

        // Export books to Excel
        Route::get('/books/export', function () {
            return Excel::download(new BooksExport, 'books.xlsx');
        })->name('books.export');

        // Export authors to Excel
        Route::get('/authors/export', function () {
            return Excel::download(new AuthorsExport, 'authors.xlsx');
        })->name('authors.export');

        // Export publishers to Excel
        Route::get('/publishers/export', function () {
            return Excel::download(new PublishersExport, 'publishers.xlsx');
        })->name('publishers.export');

        // Export book requests to Excel
        Route::get('/book-requests/export', function () {
            return Excel::download(new BookRequestsExport, 'book_requests.xlsx');
        })->name('book_requests.export');

        // Resource routes for books (create, store, edit, update, destroy)
        Route::resource('books', BookController::class)->except(['index', 'show','export']);

        // Resource routes for authors (create, store, edit, update, destroy)
        Route::resource('authors', AuthorController::class)->except(['index', 'show','export']);

        // Resource routes for publishers (create, store, edit, update, destroy)
        Route::resource('publishers', PublisherController::class)->except(['index', 'show','export']);

        // Register New Admin Route
        Route::get('/create-admin', [HomeController::class, 'create_admin'])->name('create_admin');
        Route::post('/create-admin', [HomeController::class, 'store_admin'])->name('store_admin');
    });
});

// Public book routes
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');


// Public author routes
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

// Public publisher routes
Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers.index');
Route::get('/publishers/{publisher}', [PublisherController::class, 'show'])->name('publishers.show');
