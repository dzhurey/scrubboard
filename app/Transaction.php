<?php

namespace App;

use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;
use App\BaseModel;
use App\SalesOrder;

class Transaction extends BaseModel
{
    use SingleTableInheritanceTrait;

    protected $table = 'transactions';

    protected static $singleTableTypeField = 'transaction_type';

    protected static $singleTableSubclasses = [SalesOrder::class];

    const TRANSACTION_TYPES = [
        'order' => 'Sales Order',
        'invoice' => 'Sales Invoice',
    ];

    const ORDER_TYPES = [
        'general' => 'General',
        'endorser' => 'Endorser',
    ];

    protected $fillable = [
        'transaction_type',
        'transaction_status',
        'order_type',
        'customer_id',
        'agent_id',
        'transaction_date',
        'pickup_date',
        'delivery_date',
        'original_amount',
        'discount',
        'discount_amount',
        'freight',
        'total_amount',
        'balance_due',
        'note',
    ];

    protected $searchable = [
        'customer__name'
    ];

    public function transactionLines()
    {
        return $this->hasMany('App\TransactionLine', 'transaction_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function agent()
    {
        return $this->belongsTo('App\Agent');
    }
}
