<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliverySchedule;
use App\Presenters\DeliverySchedulePresenter;
use App\Http\Requests\StoreCourierSchedule;
use App\Services\CourierSchedule\DeliveryScheduleStoreService;
use App\Services\CourierSchedule\DeliveryScheduleUpdateService;

class DeliveryScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        DeliverySchedulePresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
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
        DeliverySchedulePresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'delivery_schedule' => $presenter->transform($delivery_schedule),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create(Request $request)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
        ];
        return view('delivery_schedule.create', $data);
    }

    public function store(
        StoreCourierSchedule $request,
        DeliveryScheduleStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'delivery_schedules.index', 'data' => []], 201);
    }

    public function edit(Request $request, DeliverySchedule $delivery_schedule)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
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
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $delivery_schedule);
        return $this->renderView($request, '', [], ['route' => 'delivery_schedules.edit', 'data' => ['delivery_schedule' => $delivery_schedule->id]], 204);
    }

    public function destroy(Request $request, DeliverySchedule $delivery_schedule)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $delivery_schedule->delete();
        return $this->renderView($request, '', [], ['route' => 'delivery_schedules.index', 'data' => []], 204);
    }
}
