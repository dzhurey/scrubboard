<?php

namespace App;

use App\BaseModel;

class CourierSchedule extends BaseModel
{
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
