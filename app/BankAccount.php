<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Address;

class BankAccount extends Model
{
    protected $fillable = [
        'name',
        'bank_id',
        'account_number',
    ];

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
}
