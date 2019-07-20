<?php

namespace App\Services\ItemGroup;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\ItemGroup;

class ItemGroupStoreService extends BaseService
{
    protected $model;

    public function __construct(
        ItemGroup $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, ItemGroup $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->createItemGroup($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function getItemGroup()
    {
        return $this->model;
    }

    private function createItemGroup($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }
}
