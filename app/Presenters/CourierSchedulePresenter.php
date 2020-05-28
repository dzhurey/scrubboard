<?php

namespace App\Presenters;

use Lib\Presenters\BasePresenter;
use App\CourierSchedule;
use App\Presenters\CourierScheduleLinePresenter;
use App\Presenters\TransactionPresenter;

class CourierSchedulePresenter extends BasePresenter
{
    protected $model;
    protected $transaction_presenter;
    protected $courier_schedule_line_presenter;

    public function __construct(
        CourierSchedule $model,
        TransactionPresenter $transaction_presenter,
        CourierScheduleLinePresenter $courier_schedule_line_presenter
    ) {
        $this->model = $model;
        $this->transaction_presenter = $transaction_presenter;
        $this->courier_schedule_line_presenter = $courier_schedule_line_presenter;
    }

    public function transform($input)
    {
        $input->person = $input->person;
        $input->vehicle = $input->vehicle;
        if (!empty($input->address_id)) {
            $input->address = $input->address;
        } else {
            $agent = $input->courierScheduleLines->first()->transactionLine->transaction->agent;
            $input->address = [
                "description" => $agent->address,
                "district" => $agent->district,
                "city" => $agent->city,
                "country" => $agent->country,
                "zip_code" => $agent->zip_code,
            ];
        }
        $input->courier_schedule_lines = $input->courierScheduleLines->transform(function ($item) {
            return $this->courier_schedule_line_presenter->transform($item);
        });

        $input->transaction = $this->transaction_presenter->transform($input->courierScheduleLines->first()->transactionLine->transaction);
        return $input;
    }
}
