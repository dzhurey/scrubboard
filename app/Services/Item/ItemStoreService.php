<?php

namespace App\Services\Item;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\Item;

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
}
