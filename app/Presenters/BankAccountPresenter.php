<?php

namespace App\Presenters;

use Lib\Presenters\PresenterInterface;
use Lib\Presenters\BasePresenter;
use App\BankAccount;

class BankAccountPresenter extends BasePresenter implements PresenterInterface
{
    protected $model;

    public function __construct(BankAccount $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->bank = $input->bank;
        return $input;
    }
}
