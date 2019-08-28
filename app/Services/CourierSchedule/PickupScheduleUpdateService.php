<?php

namespace App\Services\CourierSchedule;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\PickupSchedule;
use App\Services\CourierSchedule\CourierScheduleUpdateService;

class PickupScheduleUpdateService extends CourierScheduleUpdateService
{
    const SCHEDULE_TYPE = 'pickup';
    protected $model;

    public function __construct(
        PickupSchedule $model
    ) {
        $this->model = $model;
    }
}
