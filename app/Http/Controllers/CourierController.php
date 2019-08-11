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
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'couriers' => $results->getCollection(),
        ];
        return $this->renderView($request, 'courier.index', $data, [], 200);
    }

    public function show(
        Request $request,
        Courier $courier,
        CourierPresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'courier' => $presenter->transform($courier),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('courier.create');
    }

    public function store(
        StoreCourier $request,
        CourierStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'couriers.index', 'data' => []], 201);
    }

    public function edit(Courier $courier)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('courier.edit', ['courier' => $courier]);
    }

    public function update(
        StoreCourier $request,
        Courier $courier,
        CourierStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $courier);
        return $this->renderView($request, '', [], ['route' => 'couriers.edit', 'data' => ['courier' => $courier->id]], 204);
    }

    public function destroy(Request $request, Courier $courier)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $courier->delete();
        return $this->renderView($request, '', [], ['route' => 'couriers.index', 'data' => []], 204);
    }
}
