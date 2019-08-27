<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\CourierSchedule;
use App\CourierScheduleLine;

class CourierDeliveryScheduleLinePresenter extends BasePresenter
{
    protected $model;
    protected $courier_schedule;

    public function __construct(CourierScheduleLine $model, CourierSchedule $courier_schedule) {
        $this->model = $model;
        $this->courier_schedule = $courier_schedule;
    }

    public function transform($input)
    {
        $estimation_time = date_create_from_format('H:i:s', $input->estimation_time);
        $input->estimation_time = $estimation_time->format('H:i');
        $input->transaction = $input->transaction;
        return $input;
    }
}
