<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\SalesOrder;
use App\Presenters\CustomerPresenter;

class SalesOrderPresenter extends BasePresenter
{
    protected $model;
    protected $customer_presenter;

    public function __construct(SalesOrder $model, CustomerPresenter $customer_presenter)
    {
        $this->model = $model;
        $this->customer_presenter = $customer_presenter;
    }

    public function transform($input)
    {
        $input->customer = $this->customer_presenter->transform($input->customer);
        $input->agent = $input->agent;
        $input->invoice = $input->invoice;
        $input->transaction_lines = $input->transactionLines;
        return $input;
    }
}
