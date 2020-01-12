<?php

namespace App\Services\SalesInvoice;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\SalesInvoice;
use App\TransactionLine;
use Auth;

class SalesInvoiceStoreService extends BaseService
{
    protected $model;

    public function __construct(
        SalesInvoice $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, SalesInvoice $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->createTransaction($attributes);

            if (!empty($this->model->id)) {
                $lines = $this->createTransactionLines($attributes);
                $this->model->transactionLines()->saveMany($lines);
            }
            if (!empty($this->model->order)) {
                $this->model->order->transaction_status = 'closed';
                $this->model->order->save();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createTransaction($attributes)
    {
        $attributes['transaction_type'] = SalesInvoice::TRANSACTION_TYPE;
        $attributes['transaction_status'] = 'open';
        if ($attributes['order_type'] == 'endorser') {
            $attributes['transaction_status'] = 'closed';
        }
        if (!array_key_exists('dp_amount', $attributes)) {
            $attributes['dp_amount'] = 0;
            $attributes['dp_balance_due'] = 0;
        } else {
            $attributes['dp_balance_due'] = $attributes['dp_amount'];
        }
        $attributes['order_id'] = isset($attributes['order_id']) ? $attributes['order_id'] : null;
        $attributes['balance_due'] = $attributes['total_amount'];
        $attributes['user_id'] = Auth::user()->id;
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->transaction_number = $this->model->generateTransactionNumber();
        $this->model->save();
    }

    private function createTransactionLines($attributes)
    {
        $lines = [];
        foreach ($attributes['transaction_lines'] as $key => $value) {
            $value['transaction_id'] = $this->model->id;
            $value['status'] = 'open';
            $model_line = new TransactionLine();
            array_push($lines, $this->assignAttributes($model_line, $value));
        }
        return ($lines);
    }
}
