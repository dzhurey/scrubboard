<?php

namespace App;

use App\BaseModel;

class CourierScheduleLine extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'courier_schedule_id',
        'transaction_line_id',
        'estimation_time',
        'image_name',
        'received_by',
    ];

    protected $searchable = [];

    public function courierSchedule()
    {
        return $this->belongsTo('App\CourierSchedule');
    }

    public function transactionLine()
    {
        return $this->belongsTo('App\TransactionLine');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }
}
