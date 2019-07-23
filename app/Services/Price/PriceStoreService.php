<?php

namespace App\Services\Price;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Price;
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
        $price_lines = [];
        foreach ($attributes['price_lines'] as $key => $value) {
            $model_line = new PriceLine();
            array_push($price_lines, $this->assignAttributes($model_line, $value));
        }
        return ($price_lines);
    }
}
