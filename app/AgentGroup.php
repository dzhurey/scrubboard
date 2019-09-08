<?php

namespace App;

use App\BaseModel;

class AgentGroup extends BaseModel
{
    protected $fillable = [
        'name','agent_group_code'
    ];

    protected $searchable = [
        'name','agent_group_code'
    ];

    public function agents()
    {
        return $this->hasMany('App\Agent');
    }
}
