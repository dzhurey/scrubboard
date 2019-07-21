<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Courier;

class CourierPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Courier $model)
    {
        $this->model = $model;
    }
}
