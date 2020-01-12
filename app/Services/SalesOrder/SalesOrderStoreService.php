<?php

namespace App\Services\SalesOrder;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\SalesOrder;
use App\TransactionLine;
use Auth;

class SalesOrderStoreService extends BaseService
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
            $this->createTransaction($attributes);

            if (!empty($this->model->id)) {
                $lines = $this->createTransactionLines($attributes);
                $this->model->transactionLines()->saveMany($lines);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createTransaction($attributes)
    {
        $attributes['transaction_type'] = SalesOrder::TRANSACTION_TYPE;
        $attributes['transaction_status'] = 'open';
        if ($attributes['order_type'] == 'endorser') {
            $attributes['transaction_status'] = 'closed';
        }
        $attributes['balance_due'] = $attributes['total_amount'];
        $attributes['user_id'] = Auth::user()->id;
        $this->model = $this->assignAttributes($this->model, $attributes, ['order_id', 'due_date', 'dp_amount', 'dp_balance_due']);
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
