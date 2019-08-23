<?php

namespace App\Services\Price;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Price;
use App\PriceLine;

class PriceUpdateService extends BaseService
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
            $this->updatePrice($attributes);

            if (!empty($this->model->id)) {
                $price_lines = $this->updatePriceLines($attributes);
                $this->model->priceLines()->saveMany($price_lines);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function updatePrice($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function updatePriceLines($attributes)
    {
        $price_lines = [];
        foreach ($attributes['price_lines'] as $key => $value) {
            $value['price_id'] = $this->model->id;
            $price_line = $this->getOrCreatePriceLine($value);
            array_push($price_lines, $this->assignAttributes($price_line, $value));
        }
        return $price_lines;
    }

    private function getOrCreatePriceLine($value)
    {
        $price_line = $this->model->priceLines->where('item_id', '=', $value['item_id'])->first();

        if (empty($price_line)) {
            $price_line = new PriceLine();
        }
        return $price_line;
    }
}
