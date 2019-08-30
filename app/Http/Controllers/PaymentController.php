<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Transaction;
use App\Customer;
use App\Presenters\PaymentPresenter;
use App\Http\Requests\StorePayment;
use App\Services\Payment\PaymentStoreService;
use App\Services\Payment\PaymentUpdateService;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        PaymentPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'payments' => $results->getCollection(),
        ];
        return $this->renderView($request, 'payment.index', $data, [], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        Payment $payment,
        PaymentPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'payment' => $presenter->transform($payment),
        ];
        return $this->renderView($request, '', $data, [], 200);
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

        $data = [
            'items' => Customer::orderBy('id', 'ASC')->pluck('name', 'id')
        ];
        return view('payment.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StorePayment $request,
        PaymentStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);

        return $this->renderView($request, '', [], ['route' => 'payments.index', 'data' => []], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Payment $payment)
    {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'payment' => $payment,
            'items' => Item::orderBy('id', 'ASC')->pluck('description', 'id')
        ];
        return view('payment.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(
        StorePayment $request,
        Payment $payment,
        PaymentUpdateService $service
    ) {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $payment);
        return $this->renderView($request, '', [], ['route' => 'payments.edit', 'data' => ['payment' => $payment->id]], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Payment $payment)
    {
        if (!$this->allowAny(['superadmin', 'finance'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $payment->delete();
        return $this->renderView($request, '', [], ['route' => 'payments.index', 'data' => []], 204);
    }
}
