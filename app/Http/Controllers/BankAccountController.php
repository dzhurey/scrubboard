<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\BankAccount;
use App\Bank;
use App\Http\Requests\StoreBankAccount;
use App\Services\BankAccount\BankAccountStoreService;

class BankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $bank_accounts = BankAccount::orderBy('id', 'DESC')->paginate(Config::get('constants.default_per_page'));
        return view('bank_account.index', ['bank_accounts' => $bank_accounts]);
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
        return redirect()->route('bank_accounts.index');
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
        return redirect()->route('bank_accounts.edit', ['bank_account' => $bank_account->id]);
    }

    public function destroy(BankAccount $bank_account)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $bank_account->delete();
        return redirect()->route('bank_accounts.index');
    }
}
