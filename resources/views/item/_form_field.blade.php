{{ csrf_field() }}
<div class="row">
    <div class="col-sm-6">
        <h2 class="c-form--title">Item Data</h2>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="item_type">Item type</label>
                    <select class="form-control" id="item_type" name="item_type" required>
                        <option value="item">Item</option>
                        <option value="service">Service</option>
                    </select>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="description">Description</label>
            <input class="form-control" id="description" name="description" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="item_group_id">Category</label>
                    <select class="form-control" id="item_group_id" name="item_group_id" required></select>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="item_sub_category_id">Sub category</label>
                    <select class="form-control" id="item_sub_category_id" name="item_sub_category_id" required></select>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="price_list">Price</label>
            <div class="row">
                <div class="col-sm-6">
                    <select class="form-control" id="price_list" name="price_id" required></select>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input class="form-control" id="price" name="price" required>
                        </div>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
            </div>
        </div>
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