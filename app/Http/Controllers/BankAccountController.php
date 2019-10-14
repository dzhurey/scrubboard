<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BankAccount;
use App\Bank;
use App\Presenters\BankAccountPresenter;
use App\Http\Requests\StoreBankAccount;
use App\Services\BankAccount\BankAccountStoreService;

class BankAccountController extends Controller
{
    protected $bank_account;

    public function __construct(BankAccount $bank_account)
    {
        $this->middleware('auth');
        $this->bank_account = $bank_account;
    }

    public function index(
        Request $request,
        BankAccountPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'finance', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'bank_accounts' => $results->getCollection(),
        ];
        return $this->renderView($request, 'bank_account.index', $data, [], 200);
    }

    public function create(Request $request)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $banks = Bank::orderBy('id', 'ASC')->pluck('name', 'id');
        return view('bank_account.create', ['banks' => $banks]);
    }

    public function store(
        StoreBankAccount $request,
        BankAccountStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'bank_accounts.index', 'data' => []], 201);
    }

    public function edit(Request $request, BankAccount $bank_account)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $banks = Bank::orderBy('id', 'ASC')->pluck('name', 'id');
        $data = [
            'bank_account' => $bank_account,
            'banks' => $banks,
        ];
        return view('bank_account.edit', $data);
    }

    public function show(
        Request $request,
        BankAccount $bank_account,
        BankAccountPresenter $presenter
    ) {
        if (!$this->allowAny(['superadmin', 'finance', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $data = [
            'bank_account' => $presenter->transform($bank_account),
        ];
        return $this->renderView($request, '', $data, [], 200);
    }

    public function update(
        StoreBankAccount $request,
        BankAccount $bank_account,
        BankAccountStoreService $service
    ) {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        $validated = $request->validated();
        $service->perform($validated, $bank_account);
        return $this->renderView($request, '', [], ['route' => 'bank_accounts.edit', 'data' => ['bank_account' => $bank_account->id]], 204);
    }

    public function destroy(Request $request, BankAccount $bank_account)
    {
        if (!$this->allowAny(['superadmin', 'sales'])) {
            return $this->renderError($request, __("authorize.not_superadmin"), 401);
        }

        if (!empty($bank_account->paymentMeans)) {
            return $this->renderError($request, __("rules.cannot_delete_bank_has_payment"), 422);
        }

        $bank_account->delete();
        return $this->renderView($request, '', [], ['route' => 'bank_accounts.index', 'data' => []], 204);
    }
}
