<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\Presenters\AddressPresenter;
use App\Http\Requests\StoreAddress;
use App\Services\Address\AddressStoreService;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        AddressPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'addresses' => $results->getCollection(),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function show(
        Request $request,
        Address $address,
        AddressPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'address' => $presenter->transform($address),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function store(
        StoreAddress $request,
        AddressStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], [], 201);
    }

    // public function edit(Request $request, Address $address)
    // {
    //     if (!$this->allowAny(['superadmin', 'sales'])) {
    //         return $this->renderError($request, __("authorize.not_superadmin"), 401);
    //     }

    //     $data = [
    //         'address' => $address,
    //         'address_groups' => addressGroup::orderBy('id', 'ASC')->pluck('name', 'id')
    //     ];
    //     return view('address.edit', $data);
    // }

    public function update(
        StoreAddress $request,
        Address $address,
        AddressStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $address);
        return $this->renderView($request, '', [], [], 204);
    }

    public function destroy(Request $request, Address $address)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        // if (count($address->transactions) > 0) {
        //     return $this->renderError($request, __("rules.address_has_transaction"), 422);
        // }

        if ($address->is_default) {
            return $this->renderError($request, __("rules.address_is_default"), 422);
        }

        $address->delete();
        return $this->renderView($request, '', [], [], 204);
    }
}
