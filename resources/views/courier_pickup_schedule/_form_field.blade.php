<div class="row">
    <div class="col-sm-4">
        <h2 class="c-form--title">Pickup Schedule Data</h2>
        <div class="form-group">
            <label class="c-form--label" for="transaction_number">Sales Order ID</label>
            <h3 id="transaction_number" class="font-weight-bold"></h3>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="courier_schedule">Schedule Date</label>
            <h3 id="courier_schedule" class="font-weight-bold"></h3>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="estimation_time">ETA</label>
            <h3 id="estimation_time" class="font-weight-bold"></h3>
        </div>
    </div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <h2 class="c-form--title">Customer Data</h2>
        <div class="form-group">
            <label class="c-form--label" for="customer_name">Customer Name</label>
            <h3 id="customer_name" class="font-weight-bold"></h3>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="phone_number">Phone Number</label>
            <h3 id="phone_number" class="font-weight-bold"></h3>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="address">Address</label>
            <h3 id="address" class="font-weight-bold"></h3>
        </div>
    </div>
</div>

<div class="c-table--outer mx-0">
    <table id="table-item-courier-pickup-schedule" class="c-table table table-striped">
        <thead>
            <tr>
                <th class="th-item">Description</th>
                <th class="th-note">BOR</th>
                <th class="th-note">Note</th>
            </tr>
        </thead>
    </table>
</div>

<div class="form-group">
    <label class="c-form--label" for="upload_photo">Upload photo</label>
    <input id="upload_photo" type="file" accept="image/*" capture class="form-control is-height-auto" name="image">
    <input id="method" type="hidden" name="_method" value="put">
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