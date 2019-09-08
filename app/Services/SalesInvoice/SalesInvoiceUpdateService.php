<?php

namespace App\Services\SalesInvoice;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\SalesInvoice;
use App\TransactionLine;
use App\Exceptions\UnprocessableEntityException;

class SalesInvoiceUpdateService extends BaseService
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
            $this->updateTransaction($attributes);

            if (!empty($this->model->id)) {
                $lines = $this->updateTransactionLines($attributes);
                $this->model->transactionLines()->saveMany($lines);
            }
        } catch (UnprocessableEntityException $e) {
            DB::rollBack();
            throw new UnprocessableEntityException($e->getMessage(), 1);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function updateTransaction($attributes)
    {
        $attributes['balance_due'] = $this->model->balance_due;
        $attributes['order_id'] = $this->model->order_id;
        $this->model = $this->assignAttributes($this->model, $attributes, ['transaction_type', 'transaction_status']);
        $this->model->save();
    }

    private function updateTransactionLines($attributes)
    {
        $lines = [];
        foreach ($attributes['transaction_lines'] as $key => $value) {
            $value['transaction_id'] = $this->model->id;
            $line = $this->getOrCreateTransactionLine($value);
            if ($value['status'] == 'canceled') {
                throw new UnprocessableEntityException(__("rules.cannot_cancel_item_on_invoice"));
            }
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
}
