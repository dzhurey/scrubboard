<div class="form-group">
    <label for="name">Nama</label>
    <input id="name" class="form-control" type="text" name="name" required>
    <div class="invalid-feedback">Data invalid.</div>
</div>
<div class="form-group">
    <label>List Harga</label>
    <div class="c-table--outer m-0">
        <table id="table-item-price-list" class="c-table table table-striped">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<hr class="my-4">
<div class="row">
    <div class="col-sm-6 text-left">
        <button id="button-delete" class="btn btn-danger" type="button">Delete</button>
    </div>
    <div class="col-sm-6 text-right">
        <button class="btn btn-light mr-2" type="button">Cancel</button>
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</div>