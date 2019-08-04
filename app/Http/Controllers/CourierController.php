<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Courier;
use App\Presenters\CourierPresenter;
use App\Http\Requests\StoreCourier;
use App\Services\Courier\CourierStoreService;

class CourierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        CourierPresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'couriers' => $results->getCollection(),
        ];
        return $this->renderView($request, 'courier.index', $data);
    }

    public function show(
        Request $request,
        Courier $courier,
        CourierPresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $data = [
            'courier' => $presenter->transform($courier),
        ];
        return $this->renderView($request, '', $data);
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
        return $this->renderView($request, '', [], ['route' => 'couriers.index', 'data' => []], 201);
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
        return $this->renderView($request, '', [], ['route' => 'couriers.edit', 'data' => ['courier' => $courier->id]], 204);
    }

    public function destroy(Request $request, Courier $courier)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $courier->delete();
        return $this->renderView($request, '', [], ['route' => 'couriers.index', 'data' => []], 204);
    }
}
