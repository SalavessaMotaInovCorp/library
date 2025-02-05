<?php

namespace App\Livewire;

use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Book;

class BooksTable extends DataTableComponent
{
    protected $model = Book::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSortingEnabled();
        $this->setSearchEnabled();


        $this->setTBodyAttributes([
            'default' => false,
            'class' => 'bg-white divide-y divide-gray-200',
        ]);

        $this->setTrAttributes(function ($row) {
            return [
                'default' => false,
                'class' => 'hover:bg-gray-100',
            ];
        });

        $this->setTdAttributes(function ($row, $column, $value) {
            return [
                'default' => false,
                'class' => 'text-black',
            ];
        });

        $this->setSearchPlaceholder('Search book name...');
    }


    public function query()
    {
        return Book::query()
            ->with('publisher')
            ->select('id', 'isbn', 'name', 'publisher_id', 'description', 'cover_image', 'price');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->hideIf(true),

            Column::make("Isbn", "isbn")
                ->sortable()
                ->searchable(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Publisher", "publisher.name")
                ->sortable()
                ->searchable(),
            Column::make("Description", "description")
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, $column) {
                    return Str::limit($value, 25);
                }),
            Column::make("Cover image", "cover_image")
                ->format(function ($value, $row, $column) {
                    return $value
                        ? '<img src="' . $value . '" alt="Cover image" style="height:50px;">'
                        : 'No image';
                })
                ->html(),
            Column::make("Price", "price")
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, $column) {
                    return number_format($value, 2, ',', '.') . ' €';
                }),
            Column::make("Actions")
                ->label(function ($row, $column) {
                    return '<a href="/books/' . $row->id . '" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">Details</a>';
                })
                ->html(),
        ];
    }
}
