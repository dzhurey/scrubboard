<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Item;
use App\Presenters\PriceLinePresenter;

class ItemPresenter extends BasePresenter
{
    protected $model;
    protected $price_line_presenter;

    public function __construct(Item $model, PriceLinePresenter $price_line_presenter)
    {
        $this->model = $model;
        $this->price_line_presenter = $price_line_presenter;
    }

    public function transform($input)
    {
        $input->item_sub_category = $input->itemSubCategory;
        $input->item_group = $input->itemGroup;
        $input->price_lines = $input->priceLines->transform(function ($item) {
            return $this->price_line_presenter->transform($item);
        });
        return $input;
    }
}
