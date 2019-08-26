@if ($pickup_schedules->count() == 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-pickup-schedule" class="c-table table table-striped">
        <thead>
            <tr>
                <th>Courier Name</th>
                <th>Vehicle</th>
                <th>Sales Order Id</th>
                <th>Address</th>
                <th>Total Items</th>
                <th>ETA</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/calendar.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No data pick up schedules</h2>
    <p style="opacity: 0.5">Your pick up schedules data will show here</p>
</div>
@endif
