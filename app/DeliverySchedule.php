<?php

namespace App;

use App\CourierSchedule;

class DeliverySchedule extends Transaction
{
    const SCHEDULE_TYPE = 'delivery';

    protected static $singleTableType = self::SCHEDULE_TYPE;
}
