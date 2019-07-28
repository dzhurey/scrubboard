<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Price;
use App\PriceLine;
use App\Item;
use App\Presenters\PricePresenter;
use App\Http\Requests\StorePrice;
use App\Services\Price\PriceStoreService;
use App\Services\Price\PriceUpdateService;

class PriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        PricePresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
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
        PricePresenter $presenter
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $data = [
            'price' => $presenter->transform($price),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $data = [
            'items' => Item::orderBy('id', 'ASC')->pluck('description', 'id')
        ];
        return view('price.create', $data);
    }

    public function store(
        StorePrice $request,
        PriceStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'prices.index', 'data' => []], 201);
    }

    public function edit(Price $price)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $data = [
            'price' => $price,
            'items' => Item::orderBy('id', 'ASC')->pluck('description', 'id')
        ];
        return view('price.edit', $data);
    }

    public function update(
        StorePrice $request,
        Price $price,
        PriceUpdateService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated, $price);
        return $this->renderView($request, '', [], ['route' => 'prices.edit', 'data' => ['price' => $price->id]], 204);
    }

    public function destroy(Request $request, Price $price)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $price->delete();
        return $this->renderView($request, '', [], ['route' => 'prices.index', 'data' => []], 204);
    }
}
