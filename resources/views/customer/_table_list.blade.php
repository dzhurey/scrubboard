@if ($customers->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-customer" class="c-table table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Registered</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5">
    <img src="{{ asset('assets/images/icons/users.svg') }}" width="120" style="opacity: 0.7">
    <h1 class="mt-3 mb-2">No data customers</h1>
    <p style="opacity: 0.5">Your customers data will show here</p>
</div>
@endif
