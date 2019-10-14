<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Presenters\BrandPresenter;
use App\Http\Requests\StoreBrand;
use App\Services\Brand\BrandStoreService;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        BrandPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'brands' => $results->getCollection(),
        ];
        return $this->renderView($request, 'brand.index', $data, [], 200);
    }

    public function show(
        Request $request,
        Brand $brand,
        BrandPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'brand' => $presenter->transform($brand),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create(Request $request)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('brand.create');
    }

    public function store(
        StoreBrand $request,
        BrandStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'brands.index', 'data' => []], 201);
    }

    public function edit(Request $request, Brand $brand)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('brand.edit', ['brand' => $brand]);
    }

    public function update(
        StoreBrand $request,
        Brand $brand,
        BrandStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $brand);
        return $this->renderView($request, '', [], ['route' => 'brands.edit', 'data' => ['brand' => $brand->id]], 204);
    }

    public function destroy(Request $request, Brand $brand)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (!empty($brand->transactionLines)) {
            return $this->renderError($request, __("rules.item_has_transaction"), 422);
        }

        $brand->delete();
        return $this->renderView($request, '', [], ['route' => 'brands.index', 'data' => []], 204);
    }
}
