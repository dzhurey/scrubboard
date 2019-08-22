<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\PickupSchedule;
use App\Presenters\CourierSchedulePresenter;
use App\Presenters\CourierScheduleLinePresenter;

class PickupSchedulePresenter extends CourierSchedulePresenter
{
    protected $model;
    protected $courier_schedule_line_presenter;

    public function __construct(
        PickupSchedule $model,
        CourierScheduleLinePresenter $courier_schedule_line_presenter
    ) {
        $this->model = $model;
        $this->courier_schedule_line_presenter = $courier_schedule_line_presenter;
    }
}
