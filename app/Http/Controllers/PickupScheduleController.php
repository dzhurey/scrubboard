<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PickupSchedule;
use App\Presenters\CourierSchedulePresenter;
use App\Http\Requests\StoreCourierSchedule;
use App\Services\PickupSchedule\CourierScheduleStoreService;
use App\Services\PickupSchedule\CourierScheduleUpdateService;

class PickupScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        CourierSchedulePresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'sales_invoices' => $results->getCollection(),
        ];
        return $this->renderView($request, 'sales_invoice.index', $data, [], 200);
    }

    public function show(
        Request $request,
        PickupSchedule $sales_invoice,
        CourierSchedulePresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'sales_invoice' => $presenter->transform($sales_invoice),
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
        return view('sales_invoice.create', $data);
    }

    public function store(
        StoreCourierSchedule $request,
        CourierScheduleStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'sales_invoices.index', 'data' => []], 201);
    }

    public function edit(PickupSchedule $sales_invoice)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'sales_invoice' => $sales_invoice,
            'items' => Item::orderBy('id', 'ASC')->pluck('description', 'id')
        ];
        return view('sales_invoice.edit', $data);
    }

    public function update(
        StoreCourierSchedule $request,
        PickupSchedule $sales_invoice,
        CourierScheduleUpdateService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $sales_invoice);
        return $this->renderView($request, '', [], ['route' => 'sales_invoices.edit', 'data' => ['sales_invoice' => $sales_invoice->id]], 204);
    }

    public function destroy(Request $request, PickupSchedule $sales_invoice)
    {
        if (!$this->allowUser('superadmin-only')) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $sales_invoice->transactionLines->each->delete();
        $sales_invoice->delete();
        return $this->renderView($request, '', [], ['route' => 'sales_invoices.index', 'data' => []], 204);
    }
}
