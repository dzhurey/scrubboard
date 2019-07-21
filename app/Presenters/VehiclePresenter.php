<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Vehicle;

class VehiclePresenter extends BasePresenter
{
    protected $model;

    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        return $input;
    }
}
