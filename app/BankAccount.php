<?php

namespace App;

use App\BaseModel;

class BankAccount extends BaseModel
{
    protected $fillable = [
        'name',
        'bank_id',
        'account_number',
    ];

    protected $searchable = [
        'name',
        'bank__name',
    ];

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
}
