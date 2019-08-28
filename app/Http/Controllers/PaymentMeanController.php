<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BankAccount;
use App\Payment;
use App\PaymentMean;
use App\Presenters\PaymentMeanPresenter;
use App\Http\Requests\StorePaymentMean;
use App\Http\Requests\StoreUpdatePaymentMean;
use App\Services\PaymentMean\PaymentMeanStoreService;

class PaymentMeanController extends Controller
{
    protected $bank_account;

    public function __construct(BankAccount $bank_account)
    {
        $this->middleware('auth');
        $this->bank_account = $bank_account;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        PaymentMeanPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'payment_means' => $results->getCollection(),
        ];
        return $this->renderView($request, 'payment_mean.index', $data, [], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $payment_means = PaymentMean::orderBy('id', 'ASC')->pluck('payment_date', 'id');
        return view('payment_mean.create', ['payment_means' => $payment_means]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StorePaymentMean $request,
        PaymentMeanStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'payment_means.index', 'data' => []], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        PaymentMean $bank_account,
        PaymentMeanPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'payment_mean' => $presenter->transform($payment_mean),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PaymentMean $payment_mean)
    {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $payment_means = PaymentMean::orderBy('id', 'ASC')->pluck('name', 'id');
        $data = [
            'payment_mean' => $payment_mean,
            'payment_means' => $payment_means,
        ];
        return view('payment_mean.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(
        StoreUpdatePaymentMean $request,
        PaymentMean $payment_mean,
        PaymentMeanStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $payment_mean);
        return $this->renderView($request, '', [], ['route' => 'payment_means.edit', 'data' => ['payment_mean' => $payment_mean->id]], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PaymentMean $payment_mean)
    {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $payment_mean->delete();
        return $this->renderView($request, '', [], ['route' => 'payment_means.index', 'data' => []], 204);
    }
}
