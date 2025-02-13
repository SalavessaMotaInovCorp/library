<?php

namespace App\Exports;

use App\Models\BookRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookRequestsExport implements FromCollection, withHeadings, ShouldAutoSize, withMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BookRequest::with('user','book')->get();
    }

    public function headings(): array
    {
        return [
            'User Name',
            'User Email',
            'Book Name',
            'Request Date',
            'Due Date',
            'Is Returned',
            'Is Confirmed',
            'Status',
        ];
    }

    public function map($bookRequest): array
    {
        return [
            $bookRequest->user->name,
            $bookRequest->user->email,
            $bookRequest->book->name,
            $bookRequest->request_date,
            $bookRequest->due_date,
            $bookRequest->book->is_returned ? "Yes" : "No",
            $bookRequest->isConfirmed ? "Yes" : "No",
            $bookRequest->status,
        ];
    }
}
