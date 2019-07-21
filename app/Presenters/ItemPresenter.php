<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Item;

class ItemPresenter extends BasePresenter
{
    protected $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
    }
}
