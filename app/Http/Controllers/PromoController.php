<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promo;
use App\Presenters\PromoPresenter;
use App\Http\Requests\StorePromo;
use App\Http\Requests\StoreUpdatePromo;
use App\Services\Promo\PromoStoreService;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(
        Request $request,
        PromoPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'promos' => $results->getCollection(),
        ];
        return $this->renderView($request, 'promo.index', $data, [], 200);
    }

    public function show(
        Request $request,
        Promo $promo,
        PromoPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'promo' => $presenter->transform($promo),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function showByCode(
        Request $request,
        PromoPresenter $presenter,
        $code
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $now = Carbon::now();
        $promo = Promo::where('code', $code)->first();
        if (Carbon::parse($promo->start_promo) > $now || Carbon::parse($promo->end_promo) < $now) {
            return $this->renderError($request, __("rules.promo_does_not_exist"), 404);
        }
        if (!$promo) {
            return $this->renderError($request, __("rules.promo_does_not_exist"), 404);
        }
        if (count($promo->salesOrders) > $promo->quota) {
            return $this->renderError($request, __("rules.promo_exceeds_quota"), 422);
        }
        
        $data = [
            'promo' => $presenter->transform($promo),
        ];
        
        return $this->renderView($request, '', $data, [], 200);
    }

    public function create(Request $request)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('promo.create');
    }

    public function store(
        StorePromo $request,
        PromoStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'promos.index', 'data' => []], 201);
    }

    public function edit(Request $request, Promo $promo)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        return view('promo.edit', ['promo' => $promo]);
    }

    public function update(
        StoreUpdatePromo $request,
        Promo $promo,
        PromoStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $promo);
        return $this->renderView($request, '', [], ['route' => 'promos.edit', 'data' => ['promo' => $promo->id]], 204);
    }

    public function destroy(Request $request, Promo $promo)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (count($promo->salesOrders) > 0) {
            return $this->renderError($request, __("rules.cannot_delete_promo_has_transaction"), 422);
        }

        $promo->delete();
        return $this->renderView($request, '', [], ['route' => 'promos.index', 'data' => []], 204);
    }
}
