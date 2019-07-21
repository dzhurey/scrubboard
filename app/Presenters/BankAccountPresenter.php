<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\BankAccount;

class BankAccountPresenter extends BasePresenter
{
    protected $model;

    public function __construct(BankAccount $model)
    {
        $this->model = $model;
    }
}
