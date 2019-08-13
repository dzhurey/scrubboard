<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Customer;

class CustomerPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->billing_address = $input->billingAddress();
        $input->shipping_address = $input->shippingAddress();
        return $input;
    }
}
