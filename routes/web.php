<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('books', BookController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('publishers', PublisherController::class);
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/search', SearchController::class);
