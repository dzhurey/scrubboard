@if ($sales_invoices->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-price" class="c-table table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Total item</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5">
    <img src="{{ asset('assets/images/icons/file-text.svg') }}" width="120" style="opacity: 0.7">
    <h1 class="mt-3 mb-2">No data sales invoices</h1>
    <p style="opacity: 0.5">Your sales invoices data will show here</p>
</div>
@endif
