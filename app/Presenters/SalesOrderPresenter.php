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
        $input->address = $input->address();
        $input->invoice = $input->invoice;
        $input->creator = $input->creator;
        $input->promo = $input->promo;
        $input->pickup_status = $input->deliveryStatus();
        $input->transaction_lines = $input->transactionLines->transform(function ($item) {
            $item->item = $item->item;
            $item->brand = $item->brand;
            return $item;
        });
        $input->courier_schedule = null;
        if (!empty($input->transactionLines->first()->courierScheduleLine)) {
            $input->courier_schedule = $input->transactionLines->first()->courierScheduleLine->courierSchedule;
        }
        return $input;
    }
}
