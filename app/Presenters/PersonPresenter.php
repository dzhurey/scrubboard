<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Person;

class PersonPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Person $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        return $input;
    }
}
