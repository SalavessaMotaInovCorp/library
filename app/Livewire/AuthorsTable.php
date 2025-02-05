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
                'class' => 'text-black',
            ];
        });
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
                ->format(function ($value, $row, $column) {
                    return $value
                        ? '<img src="' . $value . '" alt="Author Photo" style="height:50px;">'
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
