@if ($agents->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-agent" class="c-table table table-striped">
        <thead>
            <th>POS Type</th>
            <th>Name</th>
            <th>Telephone</th>
            <th>Mobile Phone</th>
            <th>District</th>
            <th></th>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/home.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No Data POS</h2>
    <p style="opacity: 0.5">Your POS data will show here</p>
</div>
@endif
