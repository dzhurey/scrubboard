<?php

namespace App;

use App\BaseModel;

class AgentGroup extends BaseModel
{
    protected $fillable = [
        'name',
    ];

    protected $searchable = [
        'name',
    ];

    public function agents()
    {
        return $this->hasMany('App\Agent');
    }
}
