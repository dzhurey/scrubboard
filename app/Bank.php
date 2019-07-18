<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function bankAccounts()
    {
        return $this->hasMany('App\BankAccount');
    }
}
