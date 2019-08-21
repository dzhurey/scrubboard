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
                $this->removeExcluded($attributes);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function updateTransaction($attributes)
    {
        $this->model = $this->assignAttributes($this->model, $attributes, ['transaction_type', 'transaction_status']);
        $this->model->save();
    }

    private function updateTransactionLines($attributes)
    {
        $lines = [];
        foreach ($attributes['transaction_lines'] as $key => $value) {
            $value['transaction_id'] = $this->model->id;
            $line = $this->getOrCreateTransactionLine($value);
            array_push($lines, $this->assignAttributes($line, $value));
        }
        return $lines;
    }

    private function getOrCreateTransactionLine($value)
    {
        $line = $this->model->transactionLines->where('item_id', '=', $value['item_id'])->first();
        if (empty($line)) {
            $line = new TransactionLine();
        }
        return $line;
    }

    private function removeExcluded($attributes)
    {
        $from_request = array_map(function ($item) { return $item['item_id']; }, $attributes['transaction_lines']);
        $lines = $this->model->transactionLines->pluck('item_id');
        $result = [];

        if (sizeof($from_request) < $lines->count()) {
            foreach ($lines as $line) {
                if (!in_array($line, $from_request)) {
                    array_push($result, $line);
                }
            }
        }

        $this->model->transactionLines->whereIn('item_id', $result)->each->delete();
    }
}
