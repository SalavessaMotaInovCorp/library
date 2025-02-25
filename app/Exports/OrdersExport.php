<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, withHeadings, ShouldAutoSize, withMapping
{
    /**
    * @return Collection
    */
    public function collection()
    {
        return Order::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'User ID',
            'User Name',
            'User Email',
            'Status',
            'Created at',
            'Updated at',
            'Books',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->user->id,
            $order->user->name,
            $order->user->email,
            $order->status,
            $order->created_at,
            $order->updated_at,
            $order->orderItems->map(fn($item) => $item->book->name)->implode(',  '),
        ];
    }
}
