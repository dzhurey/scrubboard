<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\SalesInvoice;

class SalesInvoicePresenter extends BasePresenter
{
    protected $model;

    public function __construct(SalesInvoice $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->customer = $input->customer;
        $input->transaction_lines = $input->transactionLines;
        return $input;
    }
}
