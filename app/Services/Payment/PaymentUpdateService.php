<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Payment;
use App\PaymentLine;

class PaymentUpdateService extends BaseService
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
            $this->updatePayment($attributes);
            
            if (!empty($this->model->id)) {
                $payment_lines = $this->updatePaymentLines($attributes);
                $this->model->paymentLines()->saveMany($payment_lines);
                $this->removeExcluded($attributes);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function updatePayment($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function updatePaymentLines($attributes)
    {
        $payment_lines = [];
        foreach ($attributes['payment_lines'] as $key => $value) {
            $value['payment_id'] = $this->model->id;
            $payment_line = $this->getOrCreatePaymentLine($value);
            array_push($payment_lines, $this->assignAttributes($payment_line, $value));
        }
        return $payment_lines;
    }

    private function getOrCreatePaymentLine($value)
    {
        $line = $this->model->paymentLines->where('transaction_id', '=', $value['transaction_id'])->first();
        if (empty($line)) {
            $line = new PaymentLine();
        }
        return $line;
    }

    private function removeExcluded($attributes)
    {
        $from_request = array_map(function ($item) { return $item['transaction_id']; }, $attributes['payment_lines']);
        $payment_lines = $this->model->paymentLines->pluck('transaction_id');
        $result = [];

        if (sizeof($from_request) < $payment_lines->count()) {
            foreach ($payment_lines as $payment_line) {
                if (!in_array($payment_line, $from_request)) {
                    array_push($result, $payment_line);
                }
            }
        }
        PaymentLine::destroy($result);
    }
}
