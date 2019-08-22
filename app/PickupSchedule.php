<?php

namespace App;

use App\CourierSchedule;

class PickupSchedule extends Transaction
{
    const SCHEDULE_TYPE = 'pickup';

    protected static $singleTableType = self::SCHEDULE_TYPE;
}
