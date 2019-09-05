<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\Price;
use App\Item;
use App\PriceLine;

class PricePresenter extends BasePresenter
{
    protected $model;

    public function __construct(Price $model)
    {
        $this->model = $model;
    }

    public function transform($input)
    {
        $input->price_line_items = $this->getFullPricelines($input);
        return $input;
    }

    private function getFullPricelines($input)
    {
        $price_lines = $input->priceLines;
        $price_lines_item_ids = $price_lines->pluck('item_id')->toArray();
        $items = Item::orderBy('id', 'asc')->get()->toArray();
        $items = array_map(function ($item) use ($price_lines_item_ids, $price_lines, $input) {
            if (in_array($item['id'], $price_lines_item_ids)) {
                $price_line = $price_lines->where('item_id', '=', $item['id'])->first();
                $price_line->item = $price_line->item->toArray();
            } else {
                $price_line = new PriceLine();
                $price_line->item = $item;
                $price_line->price = $input;
                $price_line->amount = 0;
            }
            return [
                'id' => $price_line->id,
                'item' => $price_line->item,
                'item_id' => $price_line->item['id'],
                'price_id' => $input['id'],
                'amount' => $price_line->amount
            ];
        }, $items);

        return $items;
    }
}
