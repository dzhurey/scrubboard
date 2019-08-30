<h2 class="c-form--title">Pickup Schedule Data</h2>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="transaction_number">Sales Order ID</label>
            <input type="text" id="transaction_number" class="form-control" disabled readOnly/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="estimation_time">ETA</label>
            <input type="text" id="estimation_time" class="form-control" disabled readOnly/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="courier_schedule">Schedule Date</label>
            <input class="form-control datetimepicker" id="courier_schedule" name="courier_schedule" required disabled readOnly>
        </div>
    </div>
</div>

<h2 class="c-form--title mt-4">Customer Data</h2>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="customer_name">Customer Name</label>
            <input type="text" id="customer_name" class="form-control" disabled readOnly/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" class="form-control" disabled readOnly/>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="address">Address</label>
            <textarea class="form-control" id="address" name="courier_schedule" required disabled readOnly></textarea>
        </div>
    </div>
</div>

<div class="c-table--outer mx-0">
    <table id="table-item-courier-pickup-schedule" class="c-table table table-striped">
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

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="courier_id">Upload Gambar Pickup</label>
            <input type="file" accept="image/*" capture>
            <!-- <input type="file" class="form-control-file" name="image"> -->
            <div class="invalid-feedback">Data invalid.</div>
        </div>
    </div>
</div>

<hr class="my-4">
<div class="row">
    <div class="col-sm-6 text-right">
        <button class="btn btn-light mr-2" type="button">Cancel</button>
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</div>