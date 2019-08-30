<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Payment;
use App\PaymentLine;
use App\PaymentMean;

class PaymentStoreService extends BaseService
{
    protected $model;
    protected $model_line;
    protected $model_mean;

    public function __construct(
        Payment $model,
        PaymentLine $model_line,
        PaymentMean $model_mean
    ) {
      $this->model = $model;
      $this->model_line = $model_line;
      $this->model_mean = $model_mean;
    }

    public function getModel()
    {
        return $this->model;
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
                // $lines = $this->createPaymentLines($attributes);
                // $this->model->paymentLines()->saveMany($lines);
                $this->createPaymentLine($attributes);
                $this->createPaymentMean($attributes);

                $this->updateTransactionStatus();
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

    // private function createPaymentLines($attributes)
    // {
    //     $lines = [];
    //     foreach ($attributes['payment_lines'] as $key => $value) {
    //         $value['payment_id'] = $this->model->id;
    //         $model_line = new PaymentLine();
    //         array_push($lines, $this->assignAttributes($model_line, $value));
    //     }
    //     return ($lines);
    // }

    private function createPaymentLine($attributes)
    {
        $attributes['payment_id'] = $this->model->id;
        $this->model_line = $this->assignAttributes($this->model_line, $attributes);
        $this->model_line->save();
    }

    private function createPaymentMean($attributes)
    {
        $attributes['payment_id'] = $this->model->id;
        $this->model_mean = $this->assignAttributes($this->model_mean, $attributes);
        $this->model_mean->save();
    }

    public function updateTransactionStatus()
    {
        $this->model->paymentLines->each(function ($payment_line) {
            $payment_line->transaction->transaction_status = 'closed';
            $payment_line->transaction->save();
        });
    }
}
