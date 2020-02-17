@if ($promos->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-promo" class="c-table table table-striped">
        <thead>
            <tr>
                <th>Promo Name</th>
                <th>Type</th>
                <th>Code</th>
                <th>Quota</th>
                <th>Percentage</th>
                <th>Max Promo</th>
                <th>Start</th>
                <th>End</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/package.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No Data Promo</h2>
    <p style="opacity: 0.5">Your promo data will show here</p>
</div>
@endif
