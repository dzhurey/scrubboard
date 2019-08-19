@if ($bank_accounts->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-bank" class="c-table table table-striped">
        <thead>
            <th>Nama</th>
            <th>Bank</th>
            <th>Akun</th>
            <th></th>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5">
    <img src="{{ asset('assets/images/icons/users.svg') }}" width="120" style="opacity: 0.7">
    <h1 class="mt-3 mb-2">No data bank</h1>
    <p style="opacity: 0.5">Your bank data will show here</p>
</div>
@endif
