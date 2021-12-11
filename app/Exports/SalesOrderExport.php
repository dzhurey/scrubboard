<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\SalesOrderTransactionExport;
use App\Exports\SalesOrderLineExport;

class SalesOrderExport implements WithMultipleSheets
{
    use Exportable;

    protected $year;

    public function fromDateBetween(string $date_from, string $date_to)
    {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        return $this;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = (new SalesOrderTransactionExport)->fromDateBetween($this->date_from, $this->date_to);
        $sheets[] = (new SalesOrderLineExport)->fromDateBetween($this->date_from, $this->date_to);

        return $sheets;
    }
}