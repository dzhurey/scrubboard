<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Transaction;
use App\Presenters\CustomerPresenter;

class TransactionPresenter extends BasePresenter
{
    protected $model;
    protected $customer_presenter;

    public function __construct(Transaction $model, CustomerPresenter $customer_presenter)
    {
        $this->model = $model;
        $this->customer_presenter = $customer_presenter;
    }

    public function transform($input)
    {
        $input->customer = $this->customer_presenter->transform($input->customer);
        $input->agent = $input->agent;
        $input->order = $input->order;
        $input->transaction_lines = $input->transactionLines;
        return $input;
    }
}
