<?php

namespace App\Services\Promo;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Promo;

class PromoStoreService extends BaseService
{
    protected $promo;

    public function __construct(
        Promo $promo
    ) {
      $this->promo = $promo;
    }

    public function perform(Array $attributes, Promo $promo=null)
    {
        if (!empty($promo)) {
            $this->promo = $promo;
        }
        DB::beginTransaction();
        try {
            $this->createPromo($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createPromo($attributes)
    {
        $this->promo = $this->assignAttributes($this->promo, $attributes);
        $this->promo->save();
    }
}
