<?php

namespace App\Exports;

use DateTime;
use App\TransactionLine;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SalesOrderLineExport implements FromQuery, WithHeadings, WithMapping, WithTitle
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
        return TransactionLine::query()
            ->join('transactions', 'transaction_lines.transaction_id', '=', 'transactions.id')
            ->where([
                ['transactions.transaction_type', '=', 'order'],
                ['transactions.transaction_date', '>=', $this->date_from],
                ['transactions.transaction_date', '<=', $this->date_to],
            ]);
    }

    public function headings(): array
    {
        return [
            'Item Name',
            'BOR',
            'Brand',
            'Color',
            'Promo Code',
            'Qty',
            'Unit Price',
            'Discount',
            'Total',
            'Notes',
            'Pickup Status',
            'POS',
            'Author',
            'Client',
            'Order ID',
        ];
    }

    public function map($line): array
    {
        return [
            $line->item->description,
            $line->bor,
            is_null($line->brand) ? '' : $line->brand->name,
            $line->color,
            is_null($line->promo) ? '' : $line->promo->code,
            $line->quantity,
            $line->unit_price,
            $line->discount,
            $line->amount,
            $line->note,
            is_null($line->courierScheduleLine) ? '' : $line->courierScheduleLine->courierSchedule->document_status,
            $line->transaction->agent->name,
            $line->transaction->creator->email,
            $line->transaction->customer->name,
            $line->transaction->id,
        ];
    }

    public function title(): string
    {
        return 'Order Items';
    }
}
