<?php

namespace App\Exports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BooksExport implements FromCollection, withHeadings, ShouldAutoSize, withMapping
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Book::with('publisher')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Isbn',
            'Name',
            'Publisher',
            'Description',
            'Cover Image',
            'Price',
            'Created At',
            'Updated At',
        ];
    }

    public function map($book): array
    {
        return [
            $book->id,
            $book->isbn,
            $book->name,
            $book->publisher ? $book->publisher->name : 'No publisher',
            $book->description,
            $book->cover_image,
            $book->price,
            $book->created_at,
            $book->updated_at
        ];
    }
}
