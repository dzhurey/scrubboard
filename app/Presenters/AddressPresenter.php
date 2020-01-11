<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Address;

class AddressPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Address $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->customer = $input->customer;
        return $input;
    }
}
