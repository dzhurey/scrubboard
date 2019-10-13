@if ($courier_schedules->count() > 0 || !empty($query))
<div class="c-table--outer">
    <div class="table-responsive">
        <table id="table-courier-schedule" class="c-table table table-striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Sales Order ID</th>
                    <th>BOR</th>
                    <th>Customer</th>
                    <th>Destination</th>
                    <th>Address</th>
                    <th>Item</th>
                    <th>Brand</th>
                    <th>Color</th>
                    <th>Courier</th>
                    <th>Vehicle</th>
                    <th>ETA</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/calendar.svg') }}" width="90" style="opacity: 0.3">
    <h1 class="mt-3 mb-2">No Data Courier Schedule</h1>
    <p style="opacity: 0.5">Your courier schedule data will show here</p>
</div>
@endif
