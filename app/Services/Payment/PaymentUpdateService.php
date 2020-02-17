<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Payment;
use App\PaymentMean;

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
                $payment_lines_meta = $this->updatePaymentMeans($attributes);
                $this->model->paymentMeans()->saveMany($payment_lines_meta);
                $this->removeExcluded($attributes);
                $this->updateTransaction();
                // $this->updatePaymentLine($attributes);
                // $this->updatePaymentMean($attributes);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function updatePayment($attributes)
    {
        $attributes['payment_date'] = date('Y-m-d');
        $this->model = $this->assignAttributes($this->model, $attributes, ['payment_code']);
        $this->model->save();
    }

    // private function updatePaymentLine($attributes)
    // {
    //     $model_line = $this->model->paymentLines->first();
    //     $attributes['payment_id'] = $this->model->id;
    //     $model_line = $this->assignAttributes($model_line, $attributes);
    //     $model_line->save();
    // }

    // private function updatePaymentMean($attributes)
    // {
    //     $model_mean = $this->model->paymentMeans->first();
    //     $attributes['payment_id'] = $this->model->id;
    //     $model_mean = $this->assignAttributes($model_mean, $attributes);
    //     $model_mean->save();
    // }

    private function updatePaymentMeans($attributes)
    {
        $payment_means = [];
        foreach ($attributes['payment_lines'] as $key => $value) {
            $value['payment_id'] = $this->model->id;

            $payment_mean = $this->getOrCreatePaymentMean($value);
            $payment_mean->payment_method = $value['payment_method'];
            $payment_mean->payment_type = $value['payment_type'];
            if (array_key_exists('bank_id', $value)) {
                $payment_mean->bank_id = $value['bank_id'];
            }
            if (array_key_exists('bank_account_id', $value)) {
                $payment_mean->bank_account_id = $value['bank_account_id'];
            }
            if (array_key_exists('receiver_name', $value)) {
                $payment_mean->receiver_name = $value['receiver_name'];
            }
            $payment_mean->amount = $value['amount'];
            $payment_mean->payment_date = $value['payment_date'];
            $payment_mean->note = $attributes['note'];
            array_push($payment_means, $payment_mean);
        }
        return $payment_means;
    }

    private function getOrCreatePaymentMean($value)
    {
        $line = $this->model->paymentMeans
            ->where('payment_method', '=', $value['payment_method'])
            ->where('payment_type', '=', $value['payment_type'])
            ->where('amount', '=', $value['amount'])
            ->first();

        if (empty($line)) {
            $line = new PaymentMean();
        }
        return $line;
    }

    private function removeExcluded($attributes)
    {
        $from_request = array_map(function ($item) {
            return [
                'payment_method' =>$item['payment_method'],
                'payment_type' =>$item['payment_type'],
                'amount' =>$item['amount']
            ];
        }, $attributes['payment_lines']);

        $payment_means = PaymentMean::where('payment_id', $this->model->id)->get();
        $result = [];

        if (sizeof($from_request) < $payment_means->count()) {
            foreach ($payment_means as $payment_mean) {
                $obj = [
                    'payment_method' => $payment_mean->payment_method,
                    'payment_type' => $payment_mean->payment_type,
                    'amount' => $payment_mean->amount
                ];
                if (!in_array($obj, $from_request)) {
                    array_push($result, $payment_mean);
                }
            }
        }

        if (count($result) > 0) {
            $will_deleted = array_map(function ($item) { return $item->id; }, $result);
            PaymentMean::where('id', $will_deleted)->delete();
        }
    }

    public function updateTransaction()
    {
        $transaction = $this->model->paymentLines->first()->transaction;
        if ($this->model->total_amount == $transaction->total_amount) {
            $transaction->transaction_status = 'closed';
        }
        // $totalDp = $this->model->paymentMeans->where('payment_type', 'down_payment')->sum('amount');
        $transaction->balance_due = $transaction->total_amount - $this->model->total_amount;
        // $transaction->dp_balance_due = $transaction->dp_amount - $totalDp;
        $transaction->save();
    }
}
