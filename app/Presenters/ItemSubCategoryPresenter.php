<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\ItemSubCategory;

class ItemSubCategoryPresenter extends BasePresenter
{
    protected $model;

    public function __construct(ItemSubCategory $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->item_group = $input->itemGroup;
        return $input;
    }
}
