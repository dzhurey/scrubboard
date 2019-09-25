<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\PickupSchedule;
use App\Presenters\CourierSchedulePresenter;
use App\Presenters\CourierScheduleLinePresenter;
use App\Presenters\TransactionPresenter;

class PickupSchedulePresenter extends CourierSchedulePresenter
{
    protected $model;
    protected $transaction_presenter;
    protected $courier_schedule_line_presenter;

    public function __construct(
        PickupSchedule $model,
        TransactionPresenter $transaction_presenter,
        CourierScheduleLinePresenter $courier_schedule_line_presenter
    ) {
        $this->model = $model;
        $this->transaction_presenter = $transaction_presenter;
        $this->courier_schedule_line_presenter = $courier_schedule_line_presenter;
    }
}
