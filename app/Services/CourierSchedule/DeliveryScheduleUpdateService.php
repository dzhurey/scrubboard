<?php

namespace App\Services\CourierSchedule;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\DeliverySchedule;
use App\Services\CourierSchedule\CourierScheduleUpdateService;

class DeliveryScheduleUpdateService extends CourierScheduleUpdateService
{
    const SCHEDULE_TYPE = 'delivery';
    protected $model;

    public function __construct(
        DeliverySchedule $model
    ) {
        $this->model = $model;
    }
}
