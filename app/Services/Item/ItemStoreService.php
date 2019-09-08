<?php

namespace App\Services\Item;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\Item;
use App\Price;
use App\PriceLine;
use App\ItemGroup;
use App\ItemSubCategory;
use Carbon\Carbon;

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
            $this->assignPrice($attributes);
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
        $today = Carbon::now(8);
        $year = $today->year;

        if (is_null($this->model->item_code)) {
            $item = Item::where('item_group_id',$attributes['item_group_id'])
                ->where('item_sub_category_id',$attributes['item_sub_category_id'])
                ->whereYear('updated_at',$year)
                ->orderBy('item_code','desc')
                ->first();
            $item_group_code = ItemGroup::where('id',$attributes['item_group_id'])->first();
            $item_sub_category_code = ItemSubCategory::where('id',$attributes['item_sub_category_id'])->first();
            
            if (is_null($item)) {
                $attributes['item_code'] = $item_group_code->code.$item_sub_category_code->code.'001';
            } else {
                $last_number = (int)substr($item->item_code,-3);
                $next_number = $last_number+1;
                $next_number = str_pad($next_number, 3, '0', STR_PAD_LEFT);
                $attributes['item_code'] = $item_group_code->code.$item_sub_category_code->code.$next_number;
            }
        }
        else {
            $item = Item::where('item_group_id',$attributes['item_group_id'])
                ->where('item_sub_category_id',$attributes['item_sub_category_id'])
                ->whereYear('updated_at',$year)
                ->orderBy('item_code','desc')
                ->first();
            $item_group_code = ItemGroup::where('id',$attributes['item_group_id'])->first();
            $item_sub_category_code = ItemSubCategory::where('id',$attributes['item_sub_category_id'])->first();

            $last_number = (int)substr($item->item_code,-3);
            $next_number = $last_number+1;
            $next_number = str_pad($next_number, 3, '0', STR_PAD_LEFT);
            $attributes['item_code'] = $item_group_code->code.$item_sub_category_code->code.$next_number;
        }

        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function assignPrice($attributes)
    {
        $price = Price::find($attributes['price_id']);
        $price_line = $price->priceLines->where('item_id', '=', $this->model->id)->first();
        if (empty($price_line)) {
            $price_line = new PriceLine();
            $price_line->price_id = $price->id;
            $price_line->item_id = $this->model->id;
        }
        $price_line->amount = $attributes['price'];
        $price_line->save();
    }
}
