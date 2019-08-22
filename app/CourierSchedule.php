<?php

namespace App;

use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;
use App\BaseModel;
use App\PickupSchedule;
use App\DeliverySchedule;

class CourierSchedule extends BaseModel
{
    use SingleTableInheritanceTrait;

    protected $table = 'courier_schedules';

    protected static $singleTableTypeField = 'schedule_type';

    protected static $singleTableSubclasses = [PickupSchedule::class, DeliverySchedule::class];

    const SCHEDULE_TYPES = [
        'pickup' => 'Pick Up',
        'delivery' => 'Delivery',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'courier_id',
        'vehicle_id',
        'schedule_type',
        'schedule_date',
    ];

    protected $searchable = [
        'courier__name',
        'vehicle__number',
    ];

    public function courier()
    {
        return $this->belongsTo('App\Courier');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }

    public function courierScheduleLines()
    {
        return $this->hasMany('App\CourierScheduleLine');
    }
}
