<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Payment;

class PaymentPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->customer = $input->customer;
        $input->transaction_number = $input->paymentLines->first()->transaction->transaction_number;
        $input->payment_lines = $input->paymentLines;
        $input->payment_means = $input->paymentMeans;
        return $input;
    }
}
