<?php

namespace App\Exports;

use App\Models\Publisher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PublishersExport implements FromCollection, withHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Publisher::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'logo',
            'created_at',
            'updated_at',
        ];
    }

    public function map($publisher): array
    {
        return [
            $publisher->name,
            $publisher->logo,
            $publisher->created_at,
            $publisher->updated_at,
        ];
    }
}
