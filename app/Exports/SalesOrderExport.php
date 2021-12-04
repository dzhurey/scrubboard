<?php

namespace App\Exports;

use DateTime;
use App\SalesOrder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesOrderExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function fromDateBetween(string $date_from, string $date_to)
    {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        return $this;
    }

    public function query()
    {
        return SalesOrder::query()->where([['transaction_date', '>=', $this->date_from], ['transaction_date', '<=', $this->date_to]]);
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Pre Order',
            'Author',
            'Order Type',
            'Client',
            'New Client',
            'Client District',
            'Client City',
            'POS',
            'Pickup at Outlet',
            'Pickup Date',
            'Doc Date',
            'Total Before Discount',
            'Discount',
            'Amount Disc',
            'Freight',
            'Total',
            'Booking Fee',
            'Status Order',
            'Jumlah Gear',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->is_pre_order ? 'true' : 'false',
            $order->author->email,
            $order->transaction_type,
            $order->customer->name,
            $order->customer->created_at->format('m') == DateTime::createFromFormat('Y-m-d', $order->transaction_date)->format('m') ? 'true' : 'false',
            $order->customer->shippingAddress()->district,
            $order->customer->shippingAddress()->city,
            $order->agent->name,
            $order->is_own_address ? 'false' : 'true',
            $order->pickup_date,
            $order->transaction_date,
            $order->original_amount,
            $order->discount,
            $order->discount_amount,
            $order->freight,
            $order->total_amount,
            $order->dp_amount,
            $order->transaction_status,
            count($order->transactionLines),
        ];
    }
}
