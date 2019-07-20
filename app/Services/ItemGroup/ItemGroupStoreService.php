<?php

namespace App\Services\ItemGroup;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\ItemGroup;

class ItemGroupStoreService extends BaseService
{
    protected $model;

    public function __construct(
        Vehicle $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, Vehicle $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->createVehicle($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function getVehicle()
    {
        return $this->model;
    }

    private function createVehicle($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }
}
