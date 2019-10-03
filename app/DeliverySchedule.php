<?php

namespace App;

use App\CourierSchedule;

class DeliverySchedule extends CourierSchedule
{
    public const SCHEDULE_TYPE = 'delivery';

    protected $deliveryStatusName = 'delivery_status';

    protected $courier_number_prefix = 'DEL';

    protected static $singleTableType = self::SCHEDULE_TYPE;

    protected $custom_filterable = [
        'delivery_status'
    ];

    protected $filterable = [
        'document_status'
    ];
}
