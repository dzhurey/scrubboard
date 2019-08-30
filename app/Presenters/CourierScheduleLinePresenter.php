<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Storage;
use Lib\Presenters\BasePresenter;
use App\CourierScheduleLine;
use App\Presenters\TransactionPresenter;

class CourierScheduleLinePresenter extends BasePresenter
{
    protected $model;
    protected $transaction_presenter;

    public function __construct(CourierScheduleLine $model, TransactionPresenter $transaction_presenter) {
        $this->model = $model;
        $this->transaction_presenter = $transaction_presenter;
    }

    public function transform($input)
    {
        $estimation_time = date_create_from_format('H:i:s', $input->estimation_time);
        $input->estimation_time = $estimation_time->format('H:i');
        $input->transaction = $this->transaction_presenter->transform($input->transaction);
        $input->image_path = Storage::url($input->image_name);
        return $input;
    }
}
