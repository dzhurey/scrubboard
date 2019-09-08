@if ($brands->count() > 0 || !empty($query))
<div class="c-table--outer">
    <table id="table-brand" class="c-table table table-striped">
        <thead>
            <tr>
                <th>Brand</th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
@else
<div class="text-center py-5 mt-5">
    <img src="{{ asset('assets/images/icons/package.svg') }}" width="90" style="opacity: 0.7">
    <h2 class="mt-3 mb-2 u-str">No Data Brand</h2>
    <p style="opacity: 0.5">Your brand data will show here</p>
</div>
@endif
