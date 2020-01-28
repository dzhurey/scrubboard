<?php

namespace App\Services\SalesOrder;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\SalesOrder;
use App\TransactionLine;

class SalesOrderUpdateService extends BaseService
{
    protected $model;

    public function __construct(
        SalesOrder $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, SalesOrder $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->updateTransaction($attributes);

            if (!empty($this->model->id)) {
                $lines = $this->updateTransactionLines($attributes);
                $this->model->transactionLines()->saveMany($lines);
                $this->updateTransactionStatus();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function updateTransaction($attributes)
    {
        $attributes['balance_due'] = $this->model->balance_due;
        if (!array_key_exists('dp_amount', $attributes)) {
            $attributes['dp_amount'] = $this->model->dp_amount;
            $attributes['dp_balance_due'] = $this->model->dp_balance_due;
        } else {
            $attributes['dp_balance_due'] = $attributes['dp_amount'];
        }
        $this->model = $this->assignAttributes($this->model, $attributes, ['transaction_type', 'transaction_status', 'order_id', 'due_date', 'user_id']);
        $this->model->save();
    }

    private function updateTransactionLines($attributes)
    {
        $lines = [];
        foreach ($attributes['transaction_lines'] as $key => $value) {
            $value['transaction_id'] = $this->model->id;
            $line = $this->getOrCreateTransactionLine($value);
            if ($value['status'] == 'canceled') {
                $value['quantity'] = 0;
                $value['unit_price'] = 0;
                $value['discount'] = 0;
                $value['discount_amount'] = 0;
                $value['amount'] = 0;
            }
            array_push($lines, $this->assignAttributes($line, $value));
        }
        return $lines;
    }

    private function getOrCreateTransactionLine($value)
    {
        $line = $this->model->transactionLines->where('id', '=', $value['id'])->first();
        if (empty($line)) {
            $line = new TransactionLine();
            $line->status = 'open';
        }
        return $line;
    }

    public function updateTransactionStatus()
    {
        $counter = $this->model->transactionLines->where('status', '=', 'canceled')->count();

        if ($this->model->transactionLines->count() == $counter) {
            $this->model->transaction_status = 'canceled';
            $this->model->save();
        }
    }
}
