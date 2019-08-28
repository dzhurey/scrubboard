<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Presenters\CustomerPresenter;
use App\Http\Requests\StoreCustomer;
use App\Services\Customer\CustomerStoreService;
use App\Services\Customer\CustomerUpdateService;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        CustomerPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'customers' => $results->getCollection(),
        ];
        return $this->renderView($request, 'customer.index', $data, [], 200);
    }

    public function show(
        Request $request,
        Customer $customer,
        CustomerPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'customer' => $presenter->transform($customer),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create(Request $request)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('customer.create');
    }

    public function store(
        StoreCustomer $request,
        CustomerStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'customers.index', 'data' => []], 201);
    }

    public function edit(Request $request, Customer $customer)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('customer.edit', ['customer' => $customer]);
    }

    public function update(
        StoreCustomer $request,
        Customer $customer,
        CustomerUpdateService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $customer);
        return $this->renderView($request, '', [], ['route' => 'customers.edit', 'data' => ['customer' => $customer->id]], 204);
    }

    public function destroy(Request $request, Customer $customer)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $customer->delete();
        return $this->renderView($request, '', [], ['route' => 'customers.index', 'data' => []], 204);
    }
}
