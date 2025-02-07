<?php

namespace App\Exports;

use App\Models\Author;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AuthorsExport implements FromCollection, withHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Author::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'photo',
            'created_at',
            'updated_at'
        ];
    }

    public function map($author): array
    {
        return [
            $author->name,
            $author->photo,
            $author->created_at,
            $author->updated_at
        ];
    }
}
