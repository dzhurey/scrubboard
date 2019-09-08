<?php

namespace App\Services\ItemSubCategory;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\ItemSubCategory;
use Carbon\Carbon;

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
        if (is_null($this->model->code)) {
            $today = Carbon::now(8);
            $year = $today->year;
            $item_group_category = ItemSubCategory::whereYear('created_at',$year)
                ->orderBy('code','desc')
                ->first();
            
            if (is_null($item_group_category)) {
                $attributes['code'] = '001';
            } else {
                $last_number = (int)$item_group_category->code;
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
