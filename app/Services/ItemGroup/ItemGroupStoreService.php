<?php

namespace App\Services\ItemGroup;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\ItemGroup;
use Carbon\Carbon;

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
        if (is_null($this->model->code)) {
            $today = Carbon::now(8);
            $year = $today->year;
            $item_group = ItemGroup::orderBy('code','desc')->first();

            if (is_null($item_group)) {
                $attributes['code'] = '001';
            } else {
                $last_number = (int)$item_group->code;
                $next_number = $last_number+1;
                $next_number = str_pad($next_number, 3, '0', STR_PAD_LEFT);
                $attributes['code'] = $next_number;
            }
        }
        else {
            $attributes['code'] = $this->model->code;
        }

        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }
}
