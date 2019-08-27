<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Storage;
use Lib\Presenters\BasePresenter;
use App\CourierScheduleLine;

class CourierScheduleLinePresenter extends BasePresenter
{
    protected $model;

    public function __construct(CourierScheduleLine $model) {
        $this->model = $model;
    }

    public function transform($input)
    {
        $estimation_time = date_create_from_format('H:i:s', $input->estimation_time);
        $input->estimation_time = $estimation_time->format('H:i');
        $input->transaction = $input->transaction;
        $input->image_path = Storage::url($input->image_name);
        return $input;
    }
}
