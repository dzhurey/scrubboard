<?php

namespace App\Services\Address;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Address;

class AddressStoreService extends BaseService
{
    protected $model;

    public function __construct(
        Address $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, Address $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->saveAddress($attributes);
            $this->afterSave();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function saveAddress($attributes)
    {
        $attributes['description'] = $attributes['address'];
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function afterSave()
    {
        if ($this->model->is_default) {
            $addresses = Address::where([
                ['customer_id', $this->model->customer_id],
                ['is_shipping', $this->model->is_shipping],
                ['is_billing', $this->model->is_billing],
                ['id', '!=', $this->model->id]
            ])->update(['is_default' => false]);
        }
    }
}
