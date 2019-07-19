<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\BankAccount;
use App\Bank;
use App\Http\Requests\StoreBankAccount;
use App\Services\BankAccount\BankAccountStoreService;

use Illuminate\Database\Eloquent\Builder;

class BankAccountController extends Controller
{
    protected $bank_account;

    public function __construct(BankAccount $bank_account)
    {
        $this->middleware('auth');
        $this->bank_account = $bank_account;
    }

    public function index(Request $request)
    {
        if (!$this->allowUser('superadmin-only')) {
            return back()->with('error', __("authorize.not_superadmin"));
        }

        $validated = $request->validate([
            'q' => 'string',
            'page' => '',
        ]);

        $bank_accounts = $this->search($this->bank_account, $validated)->paginate(Config::get('constants.default_per_page'));

        $data = [
            'query' => $validated,
            'bank_accounts' => $bank_accounts,
        ];
        return view('bank_account.index', $data);
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

    private function search($model, $attributes)
    {
        $searchable = $model->getSearchable();

        if(!empty($attributes['q'])) {
            foreach ($searchable as $field) {
                $sanitized = trim($attributes['q']);
                $exploded_field = explode('__', $field);
                if (count($exploded_field) > 1) {
                    $model = $model->orWhereHas($exploded_field[0], function (Builder $query) use ($exploded_field, $sanitized) {
                        $query->where($exploded_field[1], 'LIKE', "%".strtoupper($sanitized)."%");
                    });
                } else {
                    $model = $model->orWhere($field,'LIKE',"%".$sanitized."%");
                }
            }
        }

        return $model;
    }
}
