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
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'vehicles' => $results->getCollection(),
        ];
        return view('vehicle.index', $data);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('vehicle.create');
    }

    public function store(
        StoreVehicle $request,
        VehicleStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated);
        return redirect()->route('vehicles.index');
    }

    public function edit(Vehicle $vehicle)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('vehicle.edit', ['vehicle' => $vehicle]);
    }

    public function update(
        StoreVehicle $request,
        Vehicle $vehicle,
        VehicleStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated, $vehicle);
        return redirect()->route('vehicles.edit', ['vehicle' => $vehicle->id]);
    }

    public function destroy(Vehicle $vehicle)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $vehicle->delete();
        return redirect()->route('vehicles.index');
    }
}
