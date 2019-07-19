<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Courier;
use App\Http\Requests\StoreCourier;
use App\Services\Courier\CourierStoreService;

class CourierController extends Controller
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

        $couriers = Courier::orderBy('id', 'DESC')->get();
        return view('courier.index', ['couriers' => $couriers]);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('courier.create');
    }

    public function store(
        StoreCourier $request,
        CourierStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated);
        return redirect()->route('couriers.index');
    }

    public function edit(Courier $courier)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('courier.edit', ['courier' => $courier]);
    }

    public function update(
        StoreCourier $request,
        Courier $courier,
        CourierStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated, $courier);
        return redirect()->route('couriers.edit', ['courier' => $courier->id]);
    }

    public function destroy(Courier $courier)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $courier->delete();
        return redirect()->route('couriers.index');
    }
}
