<?php

namespace App\Services\CourierSchedule;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\PickupSchedule;
use App\Services\CourierSchedule\CourierScheduleStoreService;

class DeliveryScheduleStoreService extends CourierScheduleStoreService
{
    const SCHEDULE_TYPE = 'pickup';
    protected $model;

    public function __construct(
        PickupSchedule $model
    ) {
        $this->model = $model;
    }
}
