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
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'sales_orders' => $results->getCollection(),
        ];
        return $this->renderView($request, 'sales_order.index', $data, [], 200);
    }

    public function show(
        Request $request,
        SalesOrder $sales_order,
        SalesOrderPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'finance', 'operation', 'courier'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'sales_order' => $presenter->transform($sales_order),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create(Request $request)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'items' => Item::orderBy('id', 'ASC')->pluck('description', 'id')
        ];
        return view('sales_order.create', $data);
    }

    public function store(
        StoreSalesOrder $request,
        SalesOrderStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'sales_orders.index', 'data' => []], 201);
    }

    public function edit(Request $request, SalesOrder $sales_order)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'sales_order' => $sales_order,
            'items' => Item::orderBy('id', 'ASC')->pluck('description', 'id')
        ];
        return view('sales_order.edit', $data);
    }

    public function update(
        StoreSalesOrder $request,
        SalesOrder $sales_order,
        SalesOrderUpdateService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (!empty($sales_order->invoice)) {
            return $this->renderError($request, __("rules.cannot_update_order_has_invoice"), 422);
        }

        $validated = $request->validated();
        $service->perform($validated, $sales_order);
        return $this->renderView($request, '', [], ['route' => 'sales_orders.edit', 'data' => ['sales_order' => $sales_order->id]], 204);
    }

    public function destroy(Request $request, SalesOrder $sales_order)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (!empty($sales_order->invoice)) {
            return $this->renderError($request, __("rules.cannot_delete_order_has_invoice"), 422);
        }

        $sales_order->transactionLines->each->delete();
        $sales_order->delete();
        return $this->renderView($request, '', [], ['route' => 'sales_orders.index', 'data' => []], 204);
    }
}
