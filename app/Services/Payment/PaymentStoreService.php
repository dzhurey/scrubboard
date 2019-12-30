<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\Payment;
use App\PaymentLine;
use App\PaymentMean;
use Carbon\Carbon;

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
                $this->createPaymentLine($attributes);
                $this->createPaymentMean($attributes);

                $this->updateTransaction();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createPayment($attributes)
    {
        $today = Carbon::now(8);
        $year = $today->year;

        if (is_null($this->model->payment_code)) {
            $payment = Payment::where('customer_id',$attributes['customer_id'])
                ->whereYear('updated_at',$year)
                ->orderBy('payment_code','desc')
                ->first();

            if (is_null($payment)) {
                $attributes['payment_code'] = "PAY/".str_pad($attributes['customer_id'], 3, '0', STR_PAD_LEFT)."/".substr($year,-2)."000001";
            } else {
                $last_number = (int)substr($payment->payment_code,-6);
                $next_number = sprintf('%06d', $last_number+1);
                $attributes['payment_code'] = "PAY/".str_pad($attributes['customer_id'], 3, '0', STR_PAD_LEFT)."/".substr($year,-2).$next_number;
            }
        }
        else {
            $payment = Payment::where('customer_id',$attributes['customer_id'])
                ->whereYear('updated_at',$year)
                ->orderBy('payment_code','desc')
                ->first();

            $last_number = (int)substr($payment->payment_code,-6);
            $next_number = sprintf('%06d', $last_number+1);
            $attributes['payment_code'] = "PAY/".str_pad($attributes['customer_id'], 3, '0', STR_PAD_LEFT)."/".substr($year,-2).$next_number;
        }

        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function createPaymentLine($attributes)
    {
        foreach ($attributes['payment_lines'] as $item) {
            $paymentLine = new PaymentLine;
            $paymentLine->transaction_id = $attributes['transaction_id'];
            $paymentLine->amount = $item['amount'];
            $this->model->paymentLines()->save($paymentLine);
        }
    }

    private function createPaymentMean($attributes)
    {
        foreach ($attributes['payment_lines'] as $item) {
            $paymentMean = new PaymentMean;
            $paymentMean->payment_method = $item['payment_method'];
            $paymentMean->payment_type = $item['payment_type'];
            $paymentMean->bank_id = $item['bank_id'];
            $paymentMean->bank_account_id = $item['bank_account_id'];
            $paymentMean->amount = $item['amount'];
            $paymentMean->payment_date = $attributes['payment_date'];
            $paymentMean->note = $attributes['note'];
            $this->model->paymentMeans()->save($paymentMean);
        }
    }

    public function updateTransaction()
    {
        $this->model->paymentLines->each(function ($payment_line) {
            $payment_line->transaction->transaction_status = 'closed';
            $payment_line->transaction->save();
        });
    }
}
