@if ($people->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-user" class="c-table table table-striped">
        <thead>
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Username</th>
              <th>Role</th>
              <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/users.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No Data User</h2>
    <p style="opacity: 0.5">Your user data will show here</p>
</div>
@endif
