<?php

namespace App;

use App\Transaction;
use App\Scopes\Transaction\OrderScope;
use Illuminate\Database\Eloquent\Builder;

class SalesOrder extends Transaction
{
    const TRANSACTION_TYPE = 'order';
    protected $deliveryStatusName = 'pickup_status';

    protected $transaction_number_prefix = 'ORD';

    protected static $singleTableType = self::TRANSACTION_TYPE;

    protected $custom_filterable = [
        'pickup_status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderScope);
    }

    public function invoice()
    {
        return $this->hasOne('App\Transaction', 'order_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer', 'id', 'customer_id');
    }

    public function author()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function agent()
    {
        return $this->hasOne('App\Agent', 'id', 'agent_id');
    }

    public function promo()
    {
        return $this->hasOne('App\Promo', 'id', 'promo_id');
    }

    public function transactionLines()
    {
        return $this->hasMany('App\TransactionLine', 'transaction_id', 'id');
    }

    public function getLatest()
    {
        return self::latest()->first();
    }
}
