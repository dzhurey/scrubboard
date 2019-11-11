<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Storage;
use Lib\Presenters\BasePresenter;
use App\CourierScheduleLine;
use App\Presenters\TransactionPresenter;
use App\Presenters\TransactionLinePresenter;

class CourierScheduleLinePresenter extends BasePresenter
{
    protected $model;
    protected $transaction_presenter;
    protected $transaction_line_presenter;

    public function __construct(
        CourierScheduleLine $model,
        TransactionPresenter $transaction_presenter,
        TransactionLinePresenter $transaction_line_presenter
    ) {
        $this->model = $model;
        $this->transaction_presenter = $transaction_presenter;
        $this->transaction_line_presenter = $transaction_line_presenter;
    }

    public function transform($input)
    {
        $estimation_time = null;
        if (!empty($input->estimation_time)) {
            $estimation_time = date_create_from_format('H:i', $input->estimation_time);
        }
        if ($estimation_time == false) {
            $estimation_time = date_create_from_format('H:i:s', $input->estimation_time);
        }
        $input->estimation_time = !empty($estimation_time) ? $estimation_time->format('H:i') : null;
        $input->transaction_line = $this->transaction_line_presenter->transform($input->transactionLine);
        $input->transaction = $this->transaction_presenter->transform($input->transactionLine->transaction);
        $input->transaction_id = $input->transactionLine->transaction_id;
        $input->image_path = Storage::url($input->image_name);
        $input->status = $input->transactionLine->status;
        $input->courier = $input->courierSchedule->person;
        $input->vehicle = $input->courierSchedule->vehicle;
        $input->files = $input->files->transform(function ($item) {
            $item->path = Storage::url($item->name);
            return $item;
        });
        return $input;
    }
}
