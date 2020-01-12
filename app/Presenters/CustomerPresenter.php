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
        $input->billing_addresses = $input->addresses()->where('is_billing', true)->get();
        $input->shipping_addresses = $input->addresses()->where('is_shipping', true)->get();
        return $input;
    }
}
