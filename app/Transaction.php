<?php

namespace App;

use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;
use App\BaseModel;
use App\SalesOrder;
use App\SalesInvoice;
use Carbon\Carbon;
use App\Agent;

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
        'is_own_address',
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
        $today = Carbon::now(8);
        $year = $today->year;

        if (is_null($this->model)) {
            $transaction = Transaction::where('transaction_type',$this->attributes['transaction_type'])
                ->where('agent_id',$this->attributes['agent_id'])
                ->whereYear('updated_at',$year)
                ->orderBy('updated_at','desc')
                ->first();
            $agent = Agent::where('id',$this->attributes['agent_id'])->first();
            
            if (is_null($transaction)) {
                $transaction_number = "/".$agent->agent_code."/".substr($year,-2).'000001';
            } else {
                $last_number = (int)substr($transaction->transaction_number,-8);
                $next_number = $last_number+1;
                $transaction_number = "/".$agent->agent_code."/".$next_number;
            }
        }
        else {
            $transaction = Transaction::where('transaction_type',$this->attributes['transaction_type'])
                ->where('agent_id',$this->attributes['agent_id'])
                ->whereYear('updated_at',$year)
                ->orderBy('updated_at','desc')
                ->first();
            $agent = Agent::where('id',$this->attributes['agent_id'])->first();

            $last_number = (int)substr($transaction->transaction_number,-8);
            $next_number = $last_number+1;
            $transaction_number = "/".$agent->agent_code."/".$next_number;
        }
        /*
        $latest = $this->getLatest();

        if (! $latest) {
            return $this->transaction_number_prefix . '0001';
        }

        $string = preg_replace("/[^0-9\.]/", '', $latest->transaction_number);
        */
        
        return $this->transaction_number_prefix.$transaction_number;
    }

    public function address()
    {
        if ($this->is_own_address) {
            return [
                'description' => $this->customer->shippingAddress()->description,
                'district' => $this->customer->shippingAddress()->district,
                'city' => $this->customer->shippingAddress()->city,
                'country' => $this->customer->shippingAddress()->country,
                'zip_code' => $this->customer->shippingAddress()->zip_code,
            ];
        }

        return [
            'description' => $this->agent->address,
            'district' => $this->agent->district,
            'city' => $this->agent->city,
            'country' => $this->agent->country,
            'zip_code' => $this->agent->zip_code,
        ];
    }
}
