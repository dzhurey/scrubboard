<?php

namespace App\Services\SalesOrder;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\SalesOrder;
use App\TransactionLine;

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
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    private function createTransactionLines($attributes)
    {
        $lines = [];
        foreach ($attributes['lines'] as $key => $value) {
            $value['transaction_id'] = $this->model->id;
            $model_line = new TransactionLine();
            array_push($lines, $this->assignAttributes($model_line, $value));
        }
        return ($lines);
    }
}
