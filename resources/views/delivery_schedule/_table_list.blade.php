@if ($delivery_schedules->count() > 0 || !empty($query))
<div class="c-table--outer">
    <div class="table-responsive">
        <table id="table-delivery-schedule" class="c-table table table-striped">
            <thead>
                <tr>
                    <th>Delivery Code</th>
                    <th>Courier Name</th>
                    <th>Vehicle</th>
                    <th>Schedule Date</th>
                    <th>Status</th>
                    <th>Sales Invoice Number</th>
                    <th>Client Name</th>
                    <th>Destination</th>
                    <th class="th-item">Delivery Address</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/calendar.svg') }}" width="90" style="opacity: 0.3">
    <h1 class="mt-3 mb-2">No Data Delivery Schedule</h1>
    <p style="opacity: 0.5">Your delivery schedule data will show here</p>
</div>
@endif
