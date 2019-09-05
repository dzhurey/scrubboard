<?php

namespace App;

use App\BaseModel;

class Brand extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    protected $searchable = [
        'name',
    ];

    public function transactionLines()
    {
        return $this->hasMany('App\TransactionLine');
    }
}
