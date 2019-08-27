<?php

namespace App\Services\Price;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Price;
use App\Item;
use App\PriceLine;

class PriceStoreService extends BaseService
{
    protected $model;

    public function __construct(
        Price $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, Price $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->createPrice($attributes);

            if (!empty($this->model->id)) {
                $price_lines = $this->createPriceLines($attributes);
                $this->model->priceLines()->saveMany($price_lines);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createPrice($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function createPriceLines($attributes)
    {
        $attributes['price_lines'] = empty($attributes['price_lines']) ? [] : $attributes['price_lines'];
        $price_line_item_ids = array_map(function ($item) { return $item['item_id']; }, $attributes['price_lines']);
        $item_ids = Item::all()->pluck('id')->toArray();
        $item_ids = array_diff($item_ids, $price_line_item_ids);
        $price_lines = [];
        foreach ($attributes['price_lines'] as $key => $value) {
            $value['price_id'] = $this->model->id;
            $model_line = new PriceLine();
            array_push($price_lines, $this->assignAttributes($model_line, $value));
        }
        foreach ($item_ids as $item) {
            $value = [
                'price_id' => $this->model->id,
                'item_id' => $item,
                'amount' => 0
            ];
            $model_line = new PriceLine();
            array_push($price_lines, $this->assignAttributes($model_line, $value));
        }

        return ($price_lines);
    }
}
