<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Publisher;

class PublishersTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Publisher::query()->orderBy('id', 'desc');
    }

    // Configure table settings
    public function configure(): void
    {
        $this->setPrimaryKey('id'); // Set primary key
        $this->setSortingEnabled(); // Enable sorting
        $this->setSearchEnabled();  // Enable search

        $this->setTBodyAttributes([
            'default' => false,
            'class' => 'bg-white divide-y divide-gray-200', // Styling for tbody
        ]);

        $this->setTrAttributes(function ($row) {
            return [
                'default' => false,
                'class' => 'hover:bg-gray-100', // Hover effect for rows
            ];
        });

        $this->setTdAttributes(function ($row, $column, $value) {
            return [
                'default' => false,
                'class' => 'text-black p-1 text-center', // Cell styling
            ];
        });

        $this->setSearchPlaceholder('Search publisher name...'); // Custom search placeholder
    }

    // Query to fetch publisher data
    public function query()
    {
        return Publisher::query()->select('id', 'name', 'logo');
    }

    // Define table columns
    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->hideIf(true), // Hide the ID column

            Column::make("Name", "name")
                ->sortable() // Enable sorting
                ->searchable(), // Enable searching

            Column::make("Logo", "logo")
                ->format(function ($value, $row) {
                    return $value
                        ? '<label for="publisher-modal-' . $row->id . '">
                   <img src="' . $value . '" alt="Publisher Logo" style="height:60px; cursor:pointer;" class="rounded mx-auto hover:shadow-lg transition-transform hover:scale-105">
               </label>
               <input type="checkbox" id="publisher-modal-' . $row->id . '" class="modal-toggle" />
               <div class="modal" id="publisher-modal-' . $row->id . '">
                   <div class="modal-box bg-white">
                        <div class="text-center">
                            <h3 class="text-lg font-bold mb-2">Logo of:</h3>
                            <h3 class="text-xl font-semibold mb-4">' . $row->name . '</h3>
                        </div>

                        <img src="' . $value . '" alt="Publisher Logo" class="rounded-lg shadow-2xl mx-auto w-full border border-black">

                        <label for="publisher-modal-' . $row->id . '" class="btn btn-sm mt-4">Close</label>
                   </div>
               </div>'
                        : 'No image'; // Display logo or fallback text
                })
                ->html(),

            Column::make("Actions")
                ->label(function ($row, $column) {
                    return '<a href="/publishers/' . $row->id . '" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">Details</a>';
                })
                ->html(), // Action button
        ];
    }
}
