<?php

namespace App;

use App\CourierSchedule;

class DeliverySchedule extends CourierSchedule
{
    public const SCHEDULE_TYPE = 'delivery';

    protected $courier_number_prefix = 'DEL';

    protected static $singleTableType = self::SCHEDULE_TYPE;
}
