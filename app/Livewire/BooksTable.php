<?php

namespace App\Livewire;

use App\Models\Publisher;
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

        $this->setTrAttributes(function () {
            return [
                'default' => false,
                'class' => 'hover:bg-gray-100',
            ];
        });

        $this->setTdAttributes(function () {
            return [
                'default' => false,
                'class' => 'text-black p-1 text-center',
            ];
        });

        $this->setSearchPlaceholder('Search book name...');
    }

//    public function query()
//    {
//        return Book::query()
//            ->with('publisher','authors')
//            ->select('id', 'isbn', 'name','publisher_id', 'description', 'cover_image', 'price');
//    }

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

            Column::make("Authors")
                ->label(function ($row) {
                    return $row->authors->map(function ($author) {
                        return '<a href="/authors/' . $author->id . '" class="hover:underline">' . $author->name . '</a>';
                    })->join('<br/>');
                })
                ->html(),

            Column::make("Publisher", "publisher.id")
                ->format(function ($value) {

                    $publisher_name = Publisher::find($value)->name;

                    return $value
                        ? '<a href="/publishers/' . $value . '" class="hover:underline">' . $publisher_name . '</a>'
                        : 'No Publisher';
                })
                ->html()
                ->sortable(),


            Column::make("Description", "description")
                ->sortable()
                ->format(function ($value) {
                    return Str::limit($value, 25);
                }),

            Column::make("Cover image", "cover_image")
                ->format(function ($value, $row) {
                    return $value
                        ? '<label for="modal-' . $row->id . '">
                   <img src="' . $value . '" alt="Cover image" style="height:60px; cursor:pointer;" class="rounded mx-auto hover:shadow-lg transition-transform hover:scale-105">
               </label>
               <input type="checkbox" id="modal-' . $row->id . '" class="modal-toggle" />
               <div class="modal space-y-1" id="modal-' . $row->id . '">
                   <div class="modal-box bg-white">
                        <div>
                            <h3>Cover image for:</h3>
                            <h3 class="text-lg font-bold mb-4 mx-auto">' . $row->name . '</h3> <!-- Aqui foi corrigido -->
                        </div>

                        <img src="' . $value . '" alt="Cover image" class="rounded-lg shadow-2xl mx-auto w-full border-black">

                        <label for="modal-' . $row->id . '" class="btn btn-sm mt-2">Close</label>
                   </div>
               </div>'
                        : 'No image';
                })
                ->html(),


        Column::make("Price", "price")
                ->sortable()
                ->format(function ($value) {
                    return number_format($value, 2, ',', '.') . ' €';
                }),

            Column::make("Actions")
                ->label(function ($row) {
                    return '<a href="/books/' . $row->id . '" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">Details</a>';
                })
                ->html(),
        ];
    }
}
