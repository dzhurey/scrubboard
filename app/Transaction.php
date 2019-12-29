<?php

namespace App;

use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;
use App\Scopes\Transaction\OrderByTransactionDateScope;
use App\BaseModel;
use App\SalesOrder;
use App\SalesInvoice;
use Carbon\Carbon;
use App\Agent;
use App\Traits\DeliveryStatusTrait;

class Transaction extends BaseModel
{
    use DeliveryStatusTrait;
    use SingleTableInheritanceTrait;

    protected $deliveryStatusName = '';

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
        'due_date',
        'original_amount',
        'discount',
        'discount_amount',
        'freight',
        'total_amount',
        'balance_due',
        'dp_amount',
        'db_balance_due',
        'note',
        'order_id',
        'is_own_address',
    ];

    protected $searchable = [
        'customer__name'
    ];

    protected $filterable = [
        'transaction_status',
        'customer_id',
        'agent_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderByTransactionDateScope);
    }

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
        $transaction = Transaction::where('transaction_type',$this->attributes['transaction_type'])
            ->where('agent_id',$this->attributes['agent_id'])
            ->whereYear('updated_at',$year)
            ->orderBy('transaction_number','desc')
            ->first();
        $agent = Agent::where('id',$this->attributes['agent_id'])->first();

        if (is_null($this->model)) {
            if (is_null($transaction)) {
                $transaction_number = "/".$agent->agent_code."/".substr($year,-2).'000001';
            } else {
                $last_number = (int)substr($transaction->transaction_number,-6);
                $next_number = sprintf('%06d', $last_number+1);
                $transaction_number = "/".$agent->agent_code."/".substr($year,-2).$next_number;
            }
        }
        else {
            $last_number = (int)substr($transaction->transaction_number,-8);
            $next_number = sprintf('%06d', $last_number+1);
            $transaction_number = "/".$agent->agent_code."/".substr($year,-2).$next_number;
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

    public function deliveryStatus()
    {
        $delivered = $this->transactionLines->where('status', '=', 'done')->count();
        $scheduled = $this->transactionLines->where('status', '=', 'scheduled')->count();
        $open = $this->transactionLines->where('status', '=', 'open')->count();
        $canceled = $this->transactionLines->where('status', '=', 'canceled')->count();
        $total = $this->transactionLines->count();

        return $this->generateDeliveryStatus($delivered, $scheduled, $open, $total, $canceled);
    }

    public function customFilter($builder, $filters)
    {
        foreach ($filters as $value) {
            if ($value[0] == $this->deliveryStatusName) {
                if ($value[1] == '=') {
                    $transactions = $this::all()->filter(function ($item, $key) use ($value) {
                        return $this->compareStatus($item->deliveryStatus(), $value[2]);
                    });
                } else if ($value[1] == '!=') {
                    $transactions = $this::all()->reject(function ($item, $key) use ($value) {
                        return $this->compareStatus($item->deliveryStatus(), $value[2]);
                    });
                } else {
                    throw new \App\Exceptions\UnprocessableEntityException('cannot filter with '.$value[1].' notation on '.$value[0].' attributes', 1);
                }
            }

            $builder = $builder->whereIn('id', $transactions->pluck('id'));
        }

        return $builder;
    }

    private function compareStatus($status, $value)
    {
        $compare_by = [$value];

        if (strpos($value, '_') > -1) {
            $compare_by = explode('_', $value);
        }
        return in_array($status, $compare_by);
    }
}
