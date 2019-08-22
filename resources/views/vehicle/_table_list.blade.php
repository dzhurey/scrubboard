@if ($vehicles->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-vehicle" class="c-table table table-striped">
        <thead>
            <tr>
                <th>Number plate</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/truck.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No data vehicle</h2>
    <p style="opacity: 0.5">Your vehicle data will show here</p>
</div>
@endif
