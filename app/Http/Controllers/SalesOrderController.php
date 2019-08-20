<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesOrder;
use App\Item;
use App\Customer;
use App\Presenters\SalesOrderPresenter;
use App\Http\Requests\StoreSalesOrder;
use App\Services\SalesOrder\SalesOrderStoreService;
use App\Services\SalesOrder\SalesOrderUpdateService;

class SalesOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        SalesOrderPresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'prices' => $results->getCollection(),
        ];
        return $this->renderView($request, 'price.index', $data, [], 200);
    }

    public function show(
        Request $request,
        Price $price,
        SalesOrderPresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'price' => $presenter->transform($price),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'items' => Item::orderBy('id', 'ASC')->pluck('description', 'id')
        ];
        return view('price.create', $data);
    }

    public function store(
        StoreSalesOrder $request,
        SalesOrderStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'prices.index', 'data' => []], 201);
    }

    public function edit(Price $price)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'price' => $price,
            'items' => Item::orderBy('id', 'ASC')->pluck('description', 'id')
        ];
        return view('price.edit', $data);
    }

    public function update(
        StoreSalesOrder $request,
        Price $price,
        SalesOrderUpdateService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $price);
        return $this->renderView($request, '', [], ['route' => 'prices.edit', 'data' => ['price' => $price->id]], 204);
    }

    public function destroy(Request $request, Price $price)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $price->delete();
        return $this->renderView($request, '', [], ['route' => 'prices.index', 'data' => []], 204);
    }
}
