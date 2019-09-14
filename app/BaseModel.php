<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $searchable = [];
    protected $filterable = [];
    protected $custom_filterable = [];

    public function getSearchable()
    {
        return $this->searchable;
    }

    public function getFilterable()
    {
        return $this->filterable;
    }

    public function getCustomFilterable()
    {
        return $this->custom_filterable;
    }
}
