@if ($delivery_schedules->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-delivery-schedule" class="c-table table table-striped">
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
<div class="text-center py-5">
    <img src="{{ asset('assets/images/icons/calendar.svg') }}" width="120" style="opacity: 0.7">
    <h1 class="mt-3 mb-2">No data delivery schedules</h1>
    <p style="opacity: 0.5">Your delivery schedules data will show here</p>
</div>
@endif
