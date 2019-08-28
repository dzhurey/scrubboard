<?php

namespace App\Services\PaymentMean;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\PaymentMean;

class PaymentMeanStoreService extends BaseService
{
    protected $model;

    public function __construct(
        PaymentMean $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, PaymentMean $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            if (!empty($this->model->id)) {
                $this->updatePaymentMean($attributes);
            } 
            else {
                $lines = $this->createPaymentMeans($attributes);
                foreach ($lines as $line) {
                    $line->save();
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function updatePaymentMean($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function createPaymentMeans($attributes)
    {
        $lines = [];
        foreach ($attributes['payment_means'] as $key => $value) {
            $model_line = new PaymentMean();
            array_push($lines, $this->assignAttributes($model_line, $value));
        }
        return ($lines);
    }
}
