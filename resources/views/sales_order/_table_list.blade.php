@if ($sales_orders->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-sales-order" class="c-table table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>POS</th>
                <th>Order Status</th>
                <th>Pickup status</th>
                <th>Document Date</th>
                <th>Pick Up Date</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/shopping-bag.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No Data Sales Order</h2>
    <p style="opacity: 0.5">Your sales order data will show here</p>
</div>
@endif
