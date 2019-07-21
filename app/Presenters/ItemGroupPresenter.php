<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\ItemGroup;

class ItemGroupPresenter extends BasePresenter
{
    protected $model;

    public function __construct(ItemGroup $model)
    {
        $this->model = $model;
    }
}
