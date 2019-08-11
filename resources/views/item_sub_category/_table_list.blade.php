@if ($item_sub_categories->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-sub-category" class="c-table table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5">
    <img src="{{ asset('assets/images/icons/users.svg') }}" width="120" style="opacity: 0.7">
    <h1 class="mt-3 mb-2">No data item sub category</h1>
    <p style="opacity: 0.5">Your item sub category data will show here</p>
</div>
@endif
