@if ($bank_accounts->original["recordsTotal"] > 0 || !empty($query))
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
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/credit-card.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No Data Bank</h2>
    <p style="opacity: 0.5">Your bank data will show here</p>
</div>
@endif
