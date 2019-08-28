<?php

namespace App\Services\Item;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\Item;
use App\Price;
use App\PriceLine;

class ItemStoreService extends BaseService
{
    protected $model;

    public function __construct(
        Item $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, Item $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->createItem($attributes);
            $this->assignPrice($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function getItem()
    {
        return $this->model;
    }

    private function createItem($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function assignPrice($attributes)
    {
        $price = Price::orderBy('id', 'asc')->first();
        $price_line = $price->priceLines->where('item_id', '=', $this->model->id)->first();
        if (empty($price_line)) {
            $price_line = new PriceLine();
            $price_line->price_id = $price->id;
            $price_line->item_id = $this->model->id;
        }
        $price_line->amount = $attributes['price'];
        $price_line->save();
    }
}
