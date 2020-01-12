<?php

namespace App;

use App\Transaction;
use App\Scopes\Transaction\InvoiceScope;

class SalesInvoice extends Transaction
{
    const TRANSACTION_TYPE = 'invoice';
    protected $deliveryStatusName = 'delivery_status';

    protected $transaction_number_prefix = 'INV';

    protected static $singleTableType = self::TRANSACTION_TYPE;

    protected $custom_filterable = [
        'delivery_status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new InvoiceScope);
    }

    public function order()
    {
        return $this->belongsTo('App\Transaction', 'order_id');
    }

    public function getLatest()
    {
        return self::latest()->first();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
