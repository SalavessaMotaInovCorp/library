<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id'); // Set primary key
        $this->setSortingEnabled(); // Enable sorting
        $this->setSearchEnabled();  // Enable search

        $this->setTBodyAttributes([
            'default' => false,
            'class' => 'bg-white divide-y divide-gray-200', // Styling for tbody
        ]);

        $this->setTrAttributes(function () {
            return [
                'default' => false,
                'class' => 'hover:bg-gray-100', // Hover effect for rows
            ];
        });

        $this->setTdAttributes(function () {
            return [
                'default' => false,
                'class' => 'text-black p-1 text-center', // Cell styling
            ];
        });

        $this->setSearchPlaceholder('Search user name...'); // Custom search placeholder
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Profile image", "profile_photo_path")
                ->format(function ($value, $row) {
                    return $value
                        ? '<label for="modal-' . $row->id . '">
                   <img src="' . $value . '" alt="Cover image" style="height:60px; cursor:pointer;" class="rounded mx-auto hover:shadow-lg transition-transform hover:scale-105">
               </label>
               <input type="checkbox" id="modal-' . $row->id . '" class="modal-toggle" />
               <div class="modal space-y-1" id="modal-' . $row->id . '">
                   <div class="modal-box bg-white">
                        <div>
                            <h3>Profile photo for:</h3>
                            <h3 class="text-lg font-bold mb-4 mx-auto">' . $row->name . '</h3>
                        </div>

                        <img src="' . $value . '" alt="Profile photo" class="rounded-lg shadow-2xl mx-auto w-full border-black">

                        <label for="modal-' . $row->id . '" class="btn btn-sm mt-2">Close</label>
                   </div>
               </div>'
                        : 'No image'; // Display image or fallback text
                })
                ->html(),
            Column::make("Name", "name")
                ->searchable()
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Role", "role")
                ->sortable(),

            Column::make("")
                ->label(function($row) {
                    if ($row->role === 'citizen') {
                        return '<a href="' . route('book_requests.userBookRequestsForAdmin', $row->id) . '" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">Book Requests History</a>';
                    }
                    return '';
                })
                ->html(),
        ];
    }
}
