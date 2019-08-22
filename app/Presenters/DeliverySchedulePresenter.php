<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\DeliverySchedule;
use App\Presenters\CourierSchedulePresenter;
use App\Presenters\CourierScheduleLinePresenter;

class DeliverySchedulePresenter extends CourierSchedulePresenter
{
    protected $model;
    protected $courier_schedule_line_presenter;

    public function __construct(
        DeliverySchedule $model,
        CourierScheduleLinePresenter $courier_schedule_line_presenter
    ) {
        $this->model = $model;
        $this->courier_schedule_line_presenter = $courier_schedule_line_presenter;
    }
}
