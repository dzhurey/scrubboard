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

    public function transform($input)
    {
        $input->item_sub_category = $input->itemSubCategory;
        $input->item_group = $input->itemSubCategory->itemGroup;
        return $input;
    }
}
