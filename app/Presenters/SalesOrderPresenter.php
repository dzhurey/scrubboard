<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\SalesOrder;

class SalesOrderPresenter extends BasePresenter
{
    protected $model;

    public function __construct(SalesOrder $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->customer = $input->customer;
        $input->agent = $input->agent;
        $input->invoice = $input->invoice;
        $input->transaction_lines = $input->transactionLines;
        return $input;
    }
}
