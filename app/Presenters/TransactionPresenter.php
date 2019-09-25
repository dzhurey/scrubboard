<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Transaction;
use App\Presenters\CustomerPresenter;
use App\Presenters\ItemPresenter;

class TransactionPresenter extends BasePresenter
{
    protected $model;
    protected $customer_presenter;
    protected $item_presenter;

    public function __construct(
        Transaction $model,
        CustomerPresenter $customer_presenter,
        ItemPresenter $item_presenter
    ) {
        $this->model = $model;
        $this->customer_presenter = $customer_presenter;
        $this->item_presenter = $item_presenter;
    }

    public function transform($input)
    {
        $input->customer = $this->customer_presenter->transform($input->customer);
        $input->agent = $input->agent;
        $input->order = $input->order;
        $input->address = $input->address();
        $input->transaction_lines = $input->transactionLines->transform(function ($item) {
            $item->item = $item->item;
            $item->brand = $item->brand;
            return $item;
        });
        return $input;
    }
}
