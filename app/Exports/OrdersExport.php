<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'Invoice Number',
            'Customer Name',
            'Status',
            'Total Amount',
            'Date'
        ];
    }

    public function map($order): array
    {
        return [
            $order->invoice_number,
            $order->user ? $order->user->name : 'Guest',
            ucfirst($order->status),
            $order->total_amount,
            $order->created_at->format('Y-m-d H:i')
        ];
    }
}
