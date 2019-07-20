<?php

namespace App\Services\ItemSubCategory;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\ItemSubCategory;

class ItemSubCategoryStoreService extends BaseService
{
    protected $model;

    public function __construct(
        ItemSubCategory $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, ItemSubCategory $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->createItemSubCategory($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createItemSubCategory($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }
}
