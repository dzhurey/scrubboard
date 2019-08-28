<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PickupSchedule;
use App\Presenters\PickupSchedulePresenter;
use App\Http\Requests\StoreCourierSchedule;
use App\Services\CourierSchedule\PickupScheduleStoreService;
use App\Services\CourierSchedule\PickupScheduleUpdateService;

class PickupScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        PickupSchedulePresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'pickup_schedules' => $results->getCollection(),
        ];
        return $this->renderView($request, 'pickup_schedule.index', $data, [], 200);
    }

    public function show(
        Request $request,
        PickupSchedule $pickup_schedule,
        PickupSchedulePresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'pickup_schedule' => $presenter->transform($pickup_schedule),
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
        return view('pickup_schedule.create', $data);
    }

    public function store(
        StoreCourierSchedule $request,
        PickupScheduleStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'pickup_schedules.index', 'data' => []], 201);
    }

    public function edit(Request $request, PickupSchedule $pickup_schedule)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'pickup_schedule' => $pickup_schedule,
        ];
        return view('pickup_schedule.edit', $data);
    }

    public function update(
        StoreCourierSchedule $request,
        PickupSchedule $pickup_schedule,
        PickupScheduleUpdateService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $pickup_schedule);
        return $this->renderView($request, '', [], ['route' => 'pickup_schedules.edit', 'data' => ['pickup_schedule' => $pickup_schedule->id]], 204);
    }

    public function destroy(Request $request, PickupSchedule $pickup_schedule)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $pickup_schedule->delete();
        return $this->renderView($request, '', [], ['route' => 'pickup_schedules.index', 'data' => []], 204);
    }
}
