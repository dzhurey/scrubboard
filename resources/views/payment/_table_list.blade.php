@if ($payments->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-sales-invoice" class="c-table table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Document No</th>
                <th>Document Type</th>
                <th>Date</th>
                <th>Total</th>
                <th>Balance Due</th>
                <th>Total Payment</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/file-text.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No Data Payment</h2>
    <p style="opacity: 0.5">Your payment data will show here</p>
</div>
@endif
