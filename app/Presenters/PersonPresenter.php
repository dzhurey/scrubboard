<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Person;
use App\User;

class PersonPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Person $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->user = $input->user;
        $input->user['role'] = User::ROLES[$input->user->role];
        return $input;
    }
}
