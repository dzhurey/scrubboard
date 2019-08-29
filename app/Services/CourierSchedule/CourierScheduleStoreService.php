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
                $this->updateTransactionStatus();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function createCourierSchedule($attributes)
    {
        $attributes['schedule_type'] = self::SCHEDULE_TYPE;
        $this->model = $this->assignAttributes($this->model, $attributes);
        $this->model->save();
    }

    public function createCourierScheduleLines($attributes)
    {
        $lines = [];
        $excluded = ['image_name'];
        foreach ($attributes['courier_schedule_lines'] as $key => $value) {
            $value['courier_schedule_id'] = $this->model->id;
            $value['status'] = 'scheduled';
            $model_line = new CourierScheduleLine();
            array_push($lines, $this->assignAttributes($model_line, $value, $excluded));
        }
        return ($lines);
    }

    public function updateTransactionStatus()
    {
        $this->model->courierScheduleLines->each(function ($line) {
            $line->transaction->transaction_status = 'scheduled';
            $line->transaction->save();
        });
    }
}
