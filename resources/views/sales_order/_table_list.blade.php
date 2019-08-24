@if ($sales_orders->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-sales-order" class="c-table table table-striped">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Outlet</th>
                <th>Order type</th>
                <th>Document date</th>
                <th>Pick Up date</th>
                <th>Delivery date</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/shopping-bag.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2">No data sales order</h2>
    <p style="opacity: 0.5">Your sales order data will show here</p>
</div>
@endif
