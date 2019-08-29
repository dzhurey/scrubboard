<?php

namespace App;

use App\BaseModel;

class CourierScheduleLine extends BaseModel
{
    const SCHEDULE_TYPES = [
        'scheduled' => 'Scheduled',
        'overdue' => 'Overdue',
        'done' => 'Done',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'courier_schedule_id',
        'transaction_id',
        'estimation_time',
        'image_name',
        'status',
    ];

    protected $searchable = [];

    public function courierSchedule()
    {
        return $this->belongsTo('App\CourierSchedule');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }
}
