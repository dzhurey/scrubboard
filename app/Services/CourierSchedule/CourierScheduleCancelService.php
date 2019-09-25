<?php

namespace App\Services\CourierSchedule;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\CourierSchedule;

class CourierScheduleCancelService extends BaseService
{
    protected $model;

    public function perform(CourierSchedule $model)
    {
        $this->model = $model;
        DB::beginTransaction();
        try {
            $this->updateCourierSchedule();
            $this->updateTransactionLinesStatus();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function updateCourierSchedule()
    {
        $this->model->document_status = 'canceled';
        $this->model->save();
    }

    private function updateTransactionLinesStatus()
    {
        $this->model->courierScheduleLines->each(function ($item, $key) {
            $item->transactionLine->status = 'open';
            $item->transactionLine->save();
        });
    }
}
