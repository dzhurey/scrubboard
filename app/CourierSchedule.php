<?php

namespace App;

use App\BaseModel;

class DeliverySchedule extends BaseModel
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

    public function deliveryScheduleLines()
    {
        return $this->hasMany('App\DeliveryScheduleLine');
    }
}
