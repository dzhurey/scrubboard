<?php

namespace App\Services\CourierSchedule;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\CourierSchedule;
use App\CourierScheduleLine;

class CourierScheduleUpdateService extends BaseService
{
    protected $model;

    public function __construct(
        CourierSchedule $model
    ) {
      $this->model = $model;
    }

    public function perform(Array $attributes, CourierSchedule $model=null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }
        DB::beginTransaction();
        try {
            $this->updateCourierSchedule($attributes);

            if (!empty($this->model->id)) {
                $lines = $this->updateCourierScheduleLines($attributes);
                $this->model->courierScheduleLines()->saveMany($lines);
                // $this->removeExcluded($attributes);

            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function updateCourierSchedule($attributes)
    {
        $attributes['document_status'] = $this->model->document_status;
        $this->model = $this->assignAttributes($this->model, $attributes, ['courier_schedule_type']);
        $this->model->save();
    }

    private function updateCourierScheduleLines($attributes)
    {
        $lines = [];
        $excluded = ['status', 'image_name', 'received_by'];
        foreach ($attributes['courier_schedule_lines'] as $key => $value) {
            $value['courier_schedule_id'] = $this->model->id;
            $line = $this->getOrCreateCourierScheduleLine($value);
            $assigned = $this->assignAttributes($line, $value, $excluded);
            $this->updateTransactionLineStatus($assigned, $value);
            array_push($lines, $assigned);
        }
        return $lines;
    }

    private function getOrCreateCourierScheduleLine($value)
    {
        $line = $this->model->courierScheduleLines->where('transaction_line_id', '=', $value['transaction_line_id'])->first();
        if (empty($line)) {
            $line = new CourierScheduleLine();
        }
        return $line;
    }

    private function removeExcluded($attributes)
    {
        $from_request = array_map(function ($item) { return $item['transaction_id']; }, $attributes['courier_schedule_lines']);
        $lines = $this->model->courierScheduleLines->pluck('transaction_id');
        $result = [];

        if (sizeof($from_request) < $lines->count()) {
            foreach ($lines as $line) {
                if (!in_array($line, $from_request)) {
                    array_push($result, $line);
                }
            }
        }

        $this->model->courierScheduleLines->whereIn('transaction_id', $result)->each->delete();
    }

    public function updateTransactionLineStatus($line, $input)
    {
        if (!isset($input['status'])) {
            $input['status'] = 'scheduled';
        }

        $line->transactionLine->status = $input['status'];
        $line->transactionLine->save();
    }
}
