<?php

namespace App;

use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;
use App\BaseModel;
use App\PickupSchedule;
use App\DeliverySchedule;
use App\Agent;
use Carbon\Carbon;

class CourierSchedule extends BaseModel
{
    use SingleTableInheritanceTrait;

    protected $table = 'courier_schedules';

    protected $deliveryStatusName = '';

    protected $courier_number_prefix = '';

    protected static $singleTableTypeField = 'schedule_type';

    protected static $singleTableSubclasses = [PickupSchedule::class, DeliverySchedule::class];

    const SCHEDULE_TYPES = [
        'pickup' => 'Pick Up',
        'delivery' => 'Delivery',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'vehicle_id',
        'schedule_date',
        'document_status',
    ];

    protected $searchable = [
        'person__name',
        'vehicle__number',
    ];

    public function person()
    {
        return $this->belongsTo('App\Person');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }

    public function courierScheduleLines()
    {
        return $this->hasMany('App\CourierScheduleLine', 'courier_schedule_id');
    }

    public function deliveryStatus()
    {
        $delivered = $this->courierScheduleLines->filter(function ($item, $key) {
            return $item->transactionLine->status == 'done';
        })->count();
        $scheduled = $this->courierScheduleLines->filter(function ($item, $key) {
            return $item->transactionLine->status == 'scheduled';
        })->count();
        $open = $this->courierScheduleLines->filter(function ($item, $key) {
            return $item->transactionLine->status == 'open';
        })->count();
        if ($scheduled == 0 && $delivered == 0) {
            return 'open';
        }
        if ($open > 0 && $scheduled > 0) {
            return 'partial-scheduled';
        }
        if ($delivered > 0 && $delivered < $this->courierScheduleLines->count() && $open == 0) {
            return 'partial';
        } elseif ($delivered != $this->courierScheduleLines->count() && $open == 0) {
            return 'scheduled';
        }
        return 'done';
    }

    public function customFilter($builder, $filters)
    {
        foreach ($filters as $value) {
            if ($value[0] == $this->deliveryStatusName) {
                if ($value[1] == '=') {
                    $courier_schedules = $this::all()->filter(function ($item, $key) use ($value) {
                        return $this->compareStatus($item->deliveryStatus(), $value[2]);
                    });
                } else if ($value[1] == '!=') {
                    $courier_schedules = $this::all()->reject(function ($item, $key) use ($value) {
                        return $this->compareStatus($item->deliveryStatus(), $value[2]);
                    });
                } else {
                    throw new \App\Exceptions\UnprocessableEntityException('cannot filter with '.$value[1].' notation on '.$value[0].' attributes', 1);
                }
            }

            $builder = $builder->whereIn('id', $courier_schedules->pluck('id'));
        }

        return $builder;
    }

    public function generateCourierCode()
    {
        $today = Carbon::now(8);
        $year = $today->year;

        if (is_null($this->model)) {
            $courier_schedule = CourierSchedule::where('schedule_type',static::SCHEDULE_TYPE)
                ->whereYear('updated_at',$year)
                ->orderBy('courier_code','desc')
                ->first();

            if (is_null($courier_schedule)) {
                $courier_schedule_number = "/".substr($year,-2).'000001';
            } else {
                $last_number = (int)substr($courier_schedule->courier_code,-8);
                $next_number = $last_number+1;
                $courier_schedule_number = "/".$next_number;
            }
        }
        else {
            $courier_schedule = CourierSchedule::where('schedule_type',static::SCHEDULE_TYPE)
                ->whereYear('updated_at',$year)
                ->orderBy('courier_code','desc')
                ->first();

            $last_number = (int)substr($courier_schedule->courier_code,-8);
            $next_number = $last_number+1;
            $courier_schedule_number = "/".$next_number;
        }

        return $this->courier_number_prefix.$courier_schedule_number;
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
