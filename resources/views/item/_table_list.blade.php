@if ($items->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-item" class="c-table table table-striped">
        <thead>
            <tr>
                <th>Description</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5">
    <img src="{{ asset('assets/images/icons/users.svg') }}" width="120" style="opacity: 0.7">
    <h1 class="mt-3 mb-2">No data item</h1>
    <p style="opacity: 0.5">Your item data will show here</p>
</div>
@endif