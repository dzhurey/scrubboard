@if ($couriers->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-courier" class="c-table table table-striped">
        <thead>
            <th>Nama</th>
            <th>Mobile Phone</th>
            <th></th>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/users.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No data courir</h2>
    <p style="opacity: 0.5">Your courir data will show here</p>
</div>
@endif
