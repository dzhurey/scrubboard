<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 *
 */
trait DeliveryStatusTrait
{
    public function generateDeliveryStatus($delivered, $scheduled, $open, $total, $canceled)
    {
        $actived = $total - $canceled;
        if ($actived == $open) {
            return 'open';
        }
        if ($actived == $delivered) {
            return 'done';
        }
        if ($scheduled == $actived) {
            return 'scheduled';
        }
        if ($open > 0 && $scheduled > 0 && $delivered == 0) {
            return 'partial-scheduled';
        }
        if ($open > 0 && $delivered > 0) {
            return 'partial-open';
        }
        if ($delivered > 0 && $delivered < $actived && $open == 0) {
            return 'partial';
        }
    }
}
