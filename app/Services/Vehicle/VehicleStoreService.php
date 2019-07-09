<?php

namespace App\Services\Vehicle;

use Illuminate\Support\Facades\DB;
use Lib\Services\BaseService;
use App\Vehicle;

class VehicleStoreService extends BaseService
{
    protected $vehicle;

    public function __construct(
        Vehicle $vehicle
    ) {
      $this->vehicle = $vehicle;
    }

    public function perform(Array $attributes, Vehicle $vehicle=null)
    {
        if (!empty($vehicle)) {
            $this->vehicle = $vehicle;
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
        return $this->vehicle;
    }

    private function createVehicle($attributes)
    {
        $this->vehicle = $this->assignAttributes($this->vehicle, $attributes);
        $this->vehicle->save();
    }
}
