<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Payment;
use App\PaymentLine;

class PaymentStoreService extends BaseService
{
    protected $model;

    public function __construct(
        Payment $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, Payment $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->createPayment($attributes);

            if (!empty($this->model->id)) {
                $lines = $this->createPaymentLines($attributes);
                $this->model->paymentLines()->saveMany($lines);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createPayment($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function createPaymentLines($attributes)
    {
        $lines = [];
        foreach ($attributes['payment_lines'] as $key => $value) {
            $value['payment_id'] = $this->model->id;
            $model_line = new PaymentLine();
            array_push($lines, $this->assignAttributes($model_line, $value));
        }
        return ($lines);
    }
}
