<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
// use App\Http\Requests\StoreVehicle;
// use App\Services\Vehicle\VehicleStoreService;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $customers = Customer::orderBy('id', 'DESC')->get();
        return view('customer.index', ['customers' => $customers]);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('customer.create');
    }

    // public function store(
    //     StoreVehicle $request,
    //     VehicleStoreService $service
    // ) {
    //     if (!$this->allowUser('superadmin-only')) {
    //         return back()->with('error', __("authorize.not_superadmin"));
    //     }

    //     $validated = $request->validated();
    //     $service->perform($validated);
    //     return redirect()->route('vehicles.index');
    // }

    // public function edit(Vehicle $vehicle)
    // {
    //     if (!$this->allowUser('superadmin-only')) {
    //         return back()->with('error', __("authorize.not_superadmin"));
    //     }

    //     return view('vehicle.edit', ['vehicle' => $vehicle]);
    // }

    // public function update(
    //     StoreVehicle $request,
    //     Vehicle $vehicle,
    //     VehicleStoreService $service
    // ) {
    //     if (!$this->allowUser('superadmin-only')) {
    //         return back()->with('error', __("authorize.not_superadmin"));
    //     }

    //     $validated = $request->validated();
    //     $service->perform($validated, $vehicle);
    //     return redirect()->route('vehicles.edit', ['vehicle' => $vehicle->id]);
    // }

    // public function destroy(Vehicle $vehicle)
    // {
    //     if (!$this->allowUser('superadmin-only')) {
    //         return back()->with('error', __("authorize.not_superadmin"));
    //     }

    //     $vehicle->delete();
    //     return redirect()->route('vehicles.index');
    // }
}
