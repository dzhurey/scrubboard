<?php

namespace App;

use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;
use App\BaseModel;
use App\SalesOrder;
use App\SalesInvoice;

class Transaction extends BaseModel
{
    use SingleTableInheritanceTrait;

    protected $transaction_number_prefix = '';

    protected $table = 'transactions';

    protected static $singleTableTypeField = 'transaction_type';

    protected static $singleTableSubclasses = [SalesOrder::class, SalesInvoice::class];

    const TRANSACTION_TYPES = [
        'order' => 'Sales Order',
        'invoice' => 'Sales Invoice',
    ];

    const TRANSACTION_STATUS = [
        'open' => 'Open',
        'scheduled' => 'Scheduled',
        'delivered' => 'Delivered',
        'closed' => 'Closed',
        'canceled' => 'Canceled',
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
        'due_date',
        'original_amount',
        'discount',
        'discount_amount',
        'freight',
        'total_amount',
        'balance_due',
        'note',
        'order_id',
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

    public function generateTransactionNumber()
    {
        $latest = $this->getLatest();

        if (! $latest) {
            return $this->transaction_number_prefix . '0001';
        }

        $string = preg_replace("/[^0-9\.]/", '', $latest->transaction_number);

        return $this->transaction_number_prefix . sprintf('%04d', $string + 1);
    }
}
