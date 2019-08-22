<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\PriceLine;

class PriceLinePresenter extends BasePresenter
{
    protected $model;

    public function __construct(PriceLine $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->price = $input->price;
        return $input;
    }
}
