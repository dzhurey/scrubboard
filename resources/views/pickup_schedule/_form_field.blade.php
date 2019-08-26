<h2 class="c-form--title">Pickup Schedule Data</h2>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="courier_id">Courier Name</label>
            <select class="form-control" id="courier_id" name="courier_id" required>
                <option></option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="vehicle_id">Vehicle</label>
            <select class="form-control" id="vehicle_id" name="vehicle_id" required>
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
    <table id="table-so-item" class="c-table table table-striped">
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

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="note">Note</label>
            <textarea class="form-control" id="note" rows="6"></textarea>
        </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="col-sm-5">
        <div class="form-group">
            <label class="c-form--label" for="total-bd">Total Before Discount</label>
            <input class="form-control" id="total-bd" value="Rp. 200.000" readonly="">
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="c-form--label" for="discount">Discount %</label>
                    <input class="form-control" id="discount" value="10">
                </div>
            </div>
            <div class="col-sm-9">
                <div class="form-group">
                    <label class="c-form--label" for="amount-discount">Amount Discount</label>
                    <input class="form-control" id="amount-discount" value="Rp. 50.000" readonly="">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="freight">Freight</label>
            <input class="form-control" id="freight" value="Rp. 50.000">
        </div>
        <div class="form-group">
            <label class="c-form--label" for="total">Total</label>
            <input class="form-control" id="total" value="Rp. 200.000" readonly="">
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