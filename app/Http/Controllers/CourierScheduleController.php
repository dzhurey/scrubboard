<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourierSchedule;
use App\CourierScheduleLine;
use App\Presenters\CourierScheduleLinePresenter;

class CourierScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        CourierScheduleLinePresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'operation', 'courier', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'courier_schedules' => $results->getCollection(),
        ];
        return $this->renderView($request, 'courier_schedule.index', $data, [], 200);
    }
}
