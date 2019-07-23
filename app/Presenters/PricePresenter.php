<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Price;

class PricePresenter extends BasePresenter
{
    protected $model;

    public function __construct(Price $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->price_lines = $input->priceLines;
        return $input;
    }
}
