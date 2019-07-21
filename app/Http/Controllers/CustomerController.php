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

        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'customers' => $results->getCollection(),
        ];
        return view('customer.index', $data);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('customer.create');
    }

    public function store(
        StoreCustomer $request,
        CustomerStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated);
        return redirect()->route('customers.index');
    }

    public function edit(Customer $customer)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        return view('customer.edit', ['customer' => $customer]);
    }

    public function update(
        StoreCustomer $request,
        Customer $customer,
        CustomerUpdateService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated, $customer);
        return redirect()->route('customers.edit', ['customer' => $customer->id]);
    }

    public function destroy(Customer $customer)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $customer->delete();
        return redirect()->route('customers.index');
    }
}
