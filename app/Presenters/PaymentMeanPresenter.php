<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\PaymentMean;

class PaymentMeanPresenter extends BasePresenter
{
    protected $model;

    public function __construct(PaymentMean $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->payment = $input->payment;
        $input->bank_account = $input->bankAccount;
        return $input;
    }
}
