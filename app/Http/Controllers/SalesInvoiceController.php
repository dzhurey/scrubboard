<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesInvoice;
use App\Item;
use App\Customer;
use App\Presenters\SalesInvoicePresenter;
use App\Http\Requests\StoreSalesInvoice;
use App\Services\SalesInvoice\SalesInvoiceStoreService;
use App\Services\SalesInvoice\SalesInvoiceUpdateService;

class SalesInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        SalesInvoicePresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'finance'])) {
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
        SalesInvoice $sales_invoice,
        SalesInvoicePresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'sales_invoice' => $presenter->transform($sales_invoice),
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
        return view('sales_invoice.create', $data);
    }

    public function store(
        StoreSalesInvoice $request,
        SalesInvoiceStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'sales_invoices.index', 'data' => []], 201);
    }

    public function edit(Request $request, SalesInvoice $sales_invoice)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'sales_invoice' => $sales_invoice,
            'items' => Item::orderBy('id', 'ASC')->pluck('description', 'id')
        ];
        return view('sales_invoice.edit', $data);
    }

    public function update(
        StoreSalesInvoice $request,
        SalesInvoice $sales_invoice,
        SalesInvoiceUpdateService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $sales_invoice);
        return $this->renderView($request, '', [], ['route' => 'sales_invoices.edit', 'data' => ['sales_invoice' => $sales_invoice->id]], 204);
    }

    public function destroy(Request $request, SalesInvoice $sales_invoice)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $sales_invoice->transactionLines->each->delete();
        $sales_invoice->delete();
        return $this->renderView($request, '', [], ['route' => 'sales_invoices.index', 'data' => []], 204);
    }
}
