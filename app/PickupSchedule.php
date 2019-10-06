<?php

namespace App;

use App\CourierSchedule;

class PickupSchedule extends CourierSchedule
{
    public const SCHEDULE_TYPE = 'pickup';

    protected $courier_number_prefix = 'PIC';

    protected static $singleTableType = self::SCHEDULE_TYPE;

    protected $deliveryStatusName = 'pickup_status';

    protected $custom_filterable = [
        'pickup_status'
    ];

    protected $filterable = [
        'document_status'
    ];
}
