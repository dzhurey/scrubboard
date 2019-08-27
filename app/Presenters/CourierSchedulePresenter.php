<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\CourierSchedule;
use App\Presenters\CourierScheduleLinePresenter;

class CourierSchedulePresenter extends BasePresenter
{
    protected $model;
    protected $courier_schedule_line_presenter;

    public function __construct(
        CourierSchedule $model,
        CourierScheduleLinePresenter $courier_schedule_line_presenter
    ) {
        $this->model = $model;
        $this->courier_schedule_line_presenter = $courier_schedule_line_presenter;
    }

    public function transform($input)
    {
        $input->courier = $input->courier;
        $input->vehicle = $input->vehicle;
        $input->courier_schedule_lines = $input->courierScheduleLines->transform(function ($item) {
            return $this->courier_schedule_line_presenter->transform($item);
        });
        return $input;
    }
}
