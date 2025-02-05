<?php

use App\Exports\BooksExport;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/books/export', function () {
        return Excel::download(new BooksExport, 'books.xlsx');
    })->name('books.export');
    Route::resource('books', BookController::class);

    Route::resource('authors', AuthorController::class);
    Route::resource('publishers', PublisherController::class);
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/search', SearchController::class);
