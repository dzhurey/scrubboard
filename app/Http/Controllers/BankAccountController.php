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
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $results = $presenter->performCollection($request);
        $data = [
            'query' => $results->getValidated(),
            'bank_accounts' => $results->getCollection(),
        ];
        return $this->renderView($request, 'bank_account.index', $data);
    }

    public function create()
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $banks = Bank::orderBy('id', 'ASC')->pluck('name', 'id');
        return view('bank_account.create', ['banks' => $banks]);
    }

    public function store(
        StoreBankAccount $request,
        BankAccountStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated);
        return $this->renderView($request, '', [], ['route' => 'bank_accounts.index', 'data' => []], 201);
    }

    public function edit(BankAccount $bank_account)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
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
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $data = [
            'bank_account' => $presenter->transform($bank_account),
        ];
        return $this->renderView($request, '', $data);
    }

    public function update(
        StoreBankAccount $request,
        BankAccount $bank_account,
        BankAccountStoreService $service
    ) {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validated();
        $service->perform($validated, $bank_account);
        return $this->renderView($request, '', [], ['route' => 'bank_accounts.edit', 'data' => ['bank_account' => $bank_account->id]], 204);
    }

    public function destroy(BankAccount $bank_account)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $bank_account->delete();
        return $this->renderView($request, '', [], ['route' => 'bank_accounts.index', 'data' => []], 204);
    }
}
