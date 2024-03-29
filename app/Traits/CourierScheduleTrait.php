<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\CourierScheduleLine;
use App\CourierSchedule;

/**
 *
 */
trait CourierScheduleTrait
{
    public function autorizedCourierScheduleLine(CourierScheduleLine $courier_schedule_line, Request $request, $schedule_type)
    {
        if (!$this->isOwner($courier_schedule_line, $request)) {
            return false;
        }

        if (!$this->isRightType($courier_schedule_line, $schedule_type)) {
            return false;
        }

        return true;
    }

    public function autorizedCourierSchedule(CourierSchedule $courier_schedule, Request $request, $schedule_type)
    {
        if (!$courier_schedule->person->user->id == $request->user()->id) {
            return false;
        }

        if (!$courier_schedule->schedule_type == $schedule_type) {
            return false;
        }

        return true;
    }

    private function isOwner(CourierScheduleLine $courier_schedule_line, Request $request)
    {
        return $courier_schedule_line->courierSchedule->person->user->id == $request->user()->id;
    }

    private function isRightType(CourierScheduleLine $courier_schedule_line, $schedule_type)
    {
        return $courier_schedule_line->courierSchedule->schedule_type == $schedule_type;
    }
}
