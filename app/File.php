<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'courier_schedule_line_id'
    ];

    public function courierScheduleLine()
    {
        return $this->belongsTo('App\CourierScheduleLine');
    }
}
