<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\Presenters\VehiclePresenter;
use App\Http\Requests\StoreVehicle;
use App\Services\Vehicle\VehicleStoreService;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        VehiclePresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'vehicles' => $results->getCollection(),
        ];
        return $this->renderView($request, 'vehicle.index', $data, [], 200);
    }

    public function show(
        Request $request,
        Vehicle $vehicle,
        VehiclePresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'vehicle' => $presenter->transform($vehicle),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create(Request $request)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('vehicle.create');
    }

    public function store(
        StoreVehicle $request,
        VehicleStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'vehicles.index', 'data' => []], 201);
    }

    public function edit(Request $request, Vehicle $vehicle)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('vehicle.edit', ['vehicle' => $vehicle]);
    }

    public function update(
        StoreVehicle $request,
        Vehicle $vehicle,
        VehicleStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $vehicle);
        return $this->renderView($request, '', [], ['route' => 'vehicles.edit', 'data' => ['vehicle' => $vehicle->id]], 204);
    }

    public function destroy(Request $request, Vehicle $vehicle)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $vehicle->delete();
        return $this->renderView($request, '', [], ['route' => 'vehicles.index', 'data' => []], 204);
    }
}
