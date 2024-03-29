<?php

namespace App\Services\CourierSchedule;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\CourierSchedule;
use App\CourierScheduleLine;

class CourierScheduleStoreService extends BaseService
{
    const SCHEDULE_TYPE = '';
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
            $this->createCourierSchedule($attributes);

            if (!empty($this->model->id)) {
                $lines = $this->createCourierScheduleLines($attributes);
                $this->model->courierScheduleLines()->saveMany($lines);
                $this->updateTransactionLineStatus();
                $this->model->save();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function createCourierSchedule($attributes)
    {
        if (!array_key_exists('address_id', $attributes)) {
            $attributes['address_id'] = null;
        }
        $attributes['schedule_type'] = self::SCHEDULE_TYPE;
        $attributes['document_status'] = 'open';
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->courier_code = $this->model->generateCourierCode();
        $this->model->save();
    }

    public function createCourierScheduleLines($attributes)
    {
        $lines = [];
        $excluded = ['image_name', 'received_by'];
        foreach ($attributes['courier_schedule_lines'] as $key => $value) {
            $value['courier_schedule_id'] = $this->model->id;
            $model_line = new CourierScheduleLine();
            array_push($lines, $this->assignAttributes($model_line, $value, $excluded));
        }
        return ($lines);
    }

    public function updateTransactionLineStatus()
    {
        $this->model->courierScheduleLines->each(function ($line) {
            $line->transactionLine->status = 'scheduled';
            $line->transactionLine->save();
        });
    }
}
