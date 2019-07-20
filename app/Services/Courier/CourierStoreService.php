<?php

namespace App\Services\Courier;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\Courier;

class CourierStoreService extends BaseService
{
    protected $courier;

    public function __construct(
        Courier $courier
    ) {
      $this->courier = $courier;
    }

    public function perform(Array $attributes, Courier $courier=null)
    {
        if (!empty($courier)) {
            $this->courier = $courier;
        }
        DB::beginTransaction();
        try {
            $this->createCourier($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function getCourier()
    {
        return $this->courier;
    }

    private function createCourier($attributes)
    {
        $this->courier = $this->assignAttributes($this->courier, $attributes);
        $this->courier->save();
    }
}
