@if ($sales_invoices->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-sales-invoice" class="c-table table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>POS</th>
                <th>Order status</th>
                <th>Delivery status</th>
                <th>Document date</th>
                <th>Delivery date</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/file-text.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No Data Sales Invoice</h2>
    <p style="opacity: 0.5">Your sales invoice data will show here</p>
</div>
@endif
