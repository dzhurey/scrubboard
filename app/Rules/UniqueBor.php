<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\SalesOrder;
use App\TransactionLine;

class UniqueBor implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $sales_order_ids = SalesOrder::all()->pluck('id');
        $passed = TransactionLine::whereIn('transaction_id', $sales_order_ids)->where('bor', '=', $value)->doesntExist();
        return $passed;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('rules.bor_must_be_unique');
    }
}
