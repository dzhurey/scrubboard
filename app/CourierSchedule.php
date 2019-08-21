<?php

namespace App;

use App\BaseModel;

class CourierSchedule extends BaseModel
{
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
        'courier__number',
    ];

    public function courierScheduleLines()
    {
        return $this->hasMany('App\CourierScheduleLine');
    }
}
