<?php

namespace App\Http\Controllers\Courier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DeliverySchedule;
use App\DeliveryScheduleLine;
use App\Presenters\CourierDeliveryScheduleLinePresenter;
use App\Http\Requests\StoreCourierSchedule;
use App\Services\CourierSchedule\DeliveryScheduleStoreService;
use App\Services\CourierSchedule\DeliveryScheduleUpdateService;

class CourierDeliveryScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        CourierDeliveryScheduleLinePresenter $presenter
    ) {
        if (!$this->allowUser('courier-only')) {
            return $this->renderError($request, __("authorize.not_courier"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'delivery_schedules' => $results->getCollection(),
        ];
        return $this->renderView($request, 'delivery_schedule.index', $data, [], 200);
    }

    public function show(
        Request $request,
        DeliverySchedule $delivery_schedule,
        CourierDeliveryScheduleLinePresenter $presenter
    ) {
        if (!$this->allowUser('courier-only')) {
            return $this->renderError($request, __("authorize.not_courier"), 401);
        }

        $data = [
            'delivery_schedule' => $presenter->transform($delivery_schedule),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create()
    {
        if (!$this->allowUser('courier-only')) {
            return $this->renderError($request, __("authorize.not_courier"), 401);
        }

        $data = [
        ];
        return view('delivery_schedule.create', $data);
    }

    public function store(
        StoreCourierSchedule $request,
        DeliveryScheduleStoreService $service
    ) {
        if (!$this->allowUser('courier-only')) {
            return $this->renderError($request, __("authorize.not_courier"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'delivery_schedules.index', 'data' => []], 201);
    }

    public function edit(DeliverySchedule $delivery_schedule)
    {
        if (!$this->allowUser('courier-only')) {
            return $this->renderError($request, __("authorize.not_courier"), 401);
        }

        $data = [
            'delivery_schedule' => $delivery_schedule,
        ];
        return view('delivery_schedule.edit', $data);
    }

    public function update(
        StoreCourierSchedule $request,
        DeliverySchedule $delivery_schedule,
        DeliveryScheduleUpdateService $service
    ) {
        if (!$this->allowUser('courier-only')) {
            return $this->renderError($request, __("authorize.not_courier"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $delivery_schedule);
        return $this->renderView($request, '', [], ['route' => 'delivery_schedules.edit', 'data' => ['delivery_schedule' => $delivery_schedule->id]], 204);
    }

    public function destroy(Request $request, DeliverySchedule $delivery_schedule)
    {
        if (!$this->allowUser('courier-only')) {
            return $this->renderError($request, __("authorize.not_courier"), 401);
        }

        $delivery_schedule->delete();
        return $this->renderView($request, '', [], ['route' => 'delivery_schedules.index', 'data' => []], 204);
    }
}
