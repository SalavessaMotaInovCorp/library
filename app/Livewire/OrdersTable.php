<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Order;

class OrdersTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Order::query()
            ->with(['user']);
    }

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

    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->searchable()
                ->sortable(),

            Column::make("User", "user_id")
                ->format(function($value) {
                    $user_name = User::find($value)->name;
                    return $user_name . ' (id: ' . $value . ')';
                }),
            Column::make("Order Number", "id")
                ->sortable(),

            Column::make("Books")
                ->label(function($row) {
                    $booksHtml = '';
                    foreach ($row->orderItems as $item) {
                        $booksHtml .= '<p class="mb-2">- '
                            . $item->book->name
                            . ' - '
                            . $item->book->price
                            . ' €</p>';
                    }

                    return '<label for="modal-' . $row->id . '" class="cursor-pointer text-blue-600 hover:underline">
                    See books
                </label>
                <input type="checkbox" id="modal-' . $row->id . '" class="modal-toggle" />
                <div class="modal">
                    <div class="modal-box bg-white p-6">
                        <h3 class="text-lg font-bold mb-4">Order #' . $row->id . ' Books</h3>
                        ' . $booksHtml . '
                        <div class="modal-action">
                            <label for="modal-' . $row->id . '" class="btn btn-sm">Close</label>
                        </div>
                    </div>
                </div>';
                })
                ->html(),

            Column::make("Total amount", "total")
                ->sortable(),

            Column::make("Status", "status")
                ->sortable()
                ->searchable(),

            Column::make("Created", "created_at")
                ->sortable(),

            Column::make("Updated", "updated_at")
                ->sortable(),
        ];
    }
}
