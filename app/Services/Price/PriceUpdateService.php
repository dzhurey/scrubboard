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
                $this->removeExcluded($attributes);
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
            $price_line = $this->getOrCreatePriceLine($value);
            array_push($price_lines, $this->assignAttributes($price_line, $value));
        }
        return $price_lines;
    }

    private function getOrCreatePriceLine($value)
    {
        $price_line = PriceLine::find($value['id']);
        if (empty($price_line)) {
            $price_line = new PriceLine();
        }
        return $price_line;
    }

    private function removeExcluded($attributes)
    {
        $from_request = array_map(function ($item) { return $item['id']; }, $attributes['price_lines']);
        $price_lines = $this->model->priceLines->pluck('id');
        $result = [];

        if (sizeof($from_request) < $price_lines->count()) {
            foreach ($price_lines as $price_line) {
                if (!in_array($price_line, $from_request)) {
                    array_push($result, $price_line);
                }
            }
        }
        PriceLine::destroy($result);
    }
}
