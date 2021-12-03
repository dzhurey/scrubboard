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
use App\Exports\SalesOrderExport;
use App\Http\Requests\ExportSalesOrder;
use PDF;

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

        if ($request->header('Accept') == 'application/pdf') {
            $pdf = PDF::loadView('sales_order.pdf', $data);
            return $pdf->download('sales_order.pdf');
        }

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

        $has_picked = in_array($sales_order->deliveryStatus(), ['done']);

        if ($has_picked) {
            return $this->renderError($request, __("rules.cannot_cancel_order_has_picked"), 422);
        }

        if (!empty($sales_order->invoice)) {
            return $this->renderError($request, __("rules.cannot_cancel_order_has_invoice"), 422);
        }

        if (!in_array($sales_order->deliveryStatus(), ['open'])) {
            $sales_order->transaction_status = 'canceled';
            $sales_order->transactionLines->each(function ($item, $key) {
                $item->status = 'canceled';
                $item->save();
            });
            $courierSchedule = $sales_order->transactionLines->first()->courierScheduleLine->courierSchedule;
            $courierSchedule->document_status = 'canceled';
            $courierSchedule->save();
        }
        $sales_order->transaction_status = 'canceled';
        $sales_order->save();

        return $this->renderView($request, '', [], ['route' => 'sales_orders.index', 'data' => []], 204);
    }

    public function export(Request $request)
    {
        if (!$this->allowAny(['superadmin'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validate([
            'date_from' => 'required|date_format:"Y-m-d"',
            'date_to' => 'required|date_format:"Y-m-d"'
        ]);

        $fileName = "sales_orders_".$validated['date_from']."_to_".$validated['date_to'].".csv";

        return (new SalesOrderExport)->fromDateBetween($validated['date_from'], $validated['date_to'])->download($fileName);
    }
}
