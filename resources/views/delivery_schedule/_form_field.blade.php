<h2 class="c-form--title">Delivery Schedule Data</h2>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="courier_id">Courier Name</label>
            <select class="form-control select2" id="courier_id" name="courier_id" required>
                <option></option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="vehicle_id">Vehicle</label>
            <select class="form-control select2" id="vehicle_id" name="vehicle_id" required>
                <option></option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
    </div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="date">Date</label>
            <input class="form-control datetimepicker" id="date" name="date" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
    </div>
</div>

<div class="c-table--outer mx-0">
    <table id="table-so-item-delivery" class="c-table table table-striped">
        <thead>
            <tr>
                <th class="th-item">Sales Order Id</th>
                <th class="th-note">Customer</th>
                <th class="th-note">Sales Date</th>
                <th class="th-item">Address</th>
                <th class="th-price">ETA</th>
            </tr>
        </thead>
    </table>
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