<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\TransactionLine;
use App\Presenters\ItemPresenter;

class TransactionLinePresenter extends BasePresenter
{
    protected $model;
    protected $item_presenter;

    public function __construct(
        TransactionLine $model,
        ItemPresenter $item_presenter
    ) {
        $this->model = $model;
        $this->item_presenter = $item_presenter;
    }

    public function transform($input)
    {
        $input->item = $this->item_presenter->transform($input->item);
        $input->transaction_number = $input->transaction->transaction_number;
        $input->brand = $input->brand;
        $input->address = $input->transaction->address();
        return $input;
    }
}
