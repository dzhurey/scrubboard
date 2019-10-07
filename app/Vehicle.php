<?php

namespace App;

use App\BaseModel;

class Vehicle extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
    ];

    protected $searchable = [
        'number',
    ];

    public function courierSchedules()
    {
        return $this->hasMany('App\CourierSchedule', 'vehicle_id', 'id');
    }
}
