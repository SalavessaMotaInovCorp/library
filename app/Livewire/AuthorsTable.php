<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Author;

class AuthorsTable extends DataTableComponent
{
    protected $model = Author::class;

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
                'class' => 'text-black p-1 text-center',
            ];
        });


        $this->setSearchPlaceholder('Search author name...');
    }

    public function query()
    {
        return Author::query()->select('id', 'name', 'photo');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->hideIf(true),

            Column::make("Name", "name")
                ->sortable()
                ->searchable(),

            Column::make("Photo", "photo")
                ->format(function ($value, $row) {
                    return $value
                        ? '<label for="author-modal-' . $row->id . '">
                   <img src="' . $value . '" alt="Author Photo" style="height:60px; cursor:pointer;" class="rounded mx-auto hover:shadow-lg transition-transform hover:scale-105">
               </label>
               <input type="checkbox" id="author-modal-' . $row->id . '" class="modal-toggle" />
               <div class="modal" id="author-modal-' . $row->id . '">
                   <div class="modal-box bg-white">
                        <div class="text-center">
                            <h3 class="text-lg font-bold mb-2">Photo of:</h3>
                            <h3 class="text-xl font-semibold mb-4">' . $row->name . '</h3>
                        </div>

                        <img src="' . $value . '" alt="Author Photo" class="rounded-lg shadow-2xl mx-auto w-full border border-black">

                        <label for="author-modal-' . $row->id . '" class="btn btn-sm mt-4">Close</label>
                   </div>
               </div>'
                        : 'No image';
                })
                ->html(),


        Column::make("Actions")
                ->label(function ($row, $column) {
                    return '<a href="/authors/' . $row->id . '" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">Details</a>';
                })
                ->html(),
        ];
    }
}
