<?php

namespace App\Services\Brand;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\Brand;

class BrandStoreService extends BaseService
{
    protected $model;

    public function __construct(
        Brand $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, Brand $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->createBrand($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function getBrand()
    {
        return $this->model;
    }

    private function createBrand($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }
}
