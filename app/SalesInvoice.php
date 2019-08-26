<?php

namespace App;

use App\Transaction;
use App\Scopes\Transaction\InvoiceScope;

class SalesInvoice extends Transaction
{
    const TRANSACTION_TYPE = 'invoice';

    protected static $singleTableType = self::TRANSACTION_TYPE;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new InvoiceScope);
    }

    public function order()
    {
        return $this->belongsTo('App\Transaction', 'order_id');
    }
}
