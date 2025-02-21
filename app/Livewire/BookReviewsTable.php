<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\BookReview;

class BookReviewsTable extends DataTableComponent
{
    protected $model = BookReview::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchStatus(false);
    }

    public function columns(): array
    {
        return [
//            Column::make("ISBN", "book_id")
//                ->format(function ($value){
//                    $book_isbn = Book::find($value)->isbn;
//                    return $book_isbn;
//                }),

            Column::make("Id", "id")
                ->hideIf(true),

            Column::make("Book", "book_id")
                ->format(function ($value){
                   $book_name = Book::find($value)->name;
                   return $book_name;
                }),

            Column::make("User", "user_id")
                ->format(function ($value) {
                   $user_name = User::find($value)->name;
                   return $user_name;
                }),

            Column::make("Rating", "rating")
                ->sortable(),

            Column::make("Comment", "comment"),

            Column::make("Created at", "created_at")
                ->sortable(),

            Column::make("Status", "status")
                ->sortable(),

            Column::make("Actions")
                ->label(function ($row) {
                    return '<a href="' . route('book_reviews.edit', ['bookReview' => $row->id]) . '"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                    Check
                </a>';
                })
                ->html()

        ];
    }
}
