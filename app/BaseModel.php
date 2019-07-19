<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $searchable = [];

    public function getSearchable()
    {
        return $this->searchable;
    }
}
