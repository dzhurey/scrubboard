@if ($delivery_schedules->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-courier-delivery-schedule" class="c-table table table-striped">
        <thead>
            <tr>
                <th>Courier Code</th>
                <th>Vehicle</th>
                <th>Schedule Date</th>
                <th>Client Name</th>
                <th>Destination</th>
                <th class="th-item">Pickup Address</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/calendar.svg') }}" width="90" style="opacity: 0.3">
    <h1 class="mt-3 mb-2">No Data Delivery Schedule</h1>
    <p style="opacity: 0.5">Your delivery schedule data will show here</p>
</div>
@endif
