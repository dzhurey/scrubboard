<?php

namespace App;

use App\Transaction;
use App\Scopes\Transaction\OrderScope;

class SalesOrder extends Transaction
{
    const TRANSACTION_TYPE = 'order';

    protected static $singleTableType = self::TRANSACTION_TYPE;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderScope);
    }
}
