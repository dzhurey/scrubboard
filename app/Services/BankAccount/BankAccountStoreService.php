<?php

namespace App\Services\BankAccount;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Lib\Services\BaseService;
use App\BankAccount;

class BankAccountStoreService extends BaseService
{
    protected $bank_account;

    public function __construct(
        BankAccount $bank_account
    ) {
      $this->bank_account = $bank_account;
    }

    public function perform(Array $attributes, BankAccount $bank_account=null)
    {
        if (!empty($bank_account)) {
            $this->bank_account = $bank_account;
        }
        DB::beginTransaction();
        try {
            $this->createBankAccount($attributes);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    private function createBankAccount($attributes)
    {
        $this->bank_account = $this->assignAttributes($this->bank_account, $attributes);
        $this->bank_account->save();
    }
}
