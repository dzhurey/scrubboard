<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\CourierScheduleLine;

class CourierScheduleLinePresenter extends BasePresenter
{
    protected $model;

    public function __construct(CourierScheduleLine $model) {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->transaction = $input->transaction;
        return $input;
    }
}
