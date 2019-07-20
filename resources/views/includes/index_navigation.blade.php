<div class="row justify-content-end">
    <div class="col-4">
        <div class="input-group">
            <input type="text" class="form-control" aria-label="Cari" id="inputSearch" value="@if (!empty($query['q'])) {{ $query['q'] }} @endif">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="btnSearch">Cari</button>
            </div>
        </div>
    </div>
</div>