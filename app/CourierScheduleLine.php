<?php

namespace App;

use App\BaseModel;

class DeliveryScheduleLine extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'delivery_schedule_id',
        'transaction_id',
        'estimation_time',
        'image_name',
        'status',
    ];

    protected $searchable = [];

    public function deliverySchedule()
    {
        return $this->belongsTo('App\DeliverySchedule');
    }
}
