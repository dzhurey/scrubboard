<h2 class="c-form--title">Pickup Schedule Data</h2>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="person_id">Courier Name</label>
            <select class="form-control select2" id="person_id" name="person_id" required>
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
        <div class="form-group">
            <label class="c-form--label" for="document_status">Document Status</label>
            <input class="form-control" id="document_status" name="document_status" value="open" disabled>
        </div>
    </div>
</div>

<div class="form-group mt-4">
    <div class="alert alert-warning"><i class="fa fa-info-circle mr-1"></i> After you choosed sales order please fill address and ETA on item. uncheck if you wan't to pickup that item</div>
</div>

<div class="form-group">
    <div id="courier_schedule_lines" class="c-table--outer mx-0">
        <table id="table-so-item-pickup" class="c-table table table-striped">
            <thead>
                <tr>
                    <th class="checkbox"></th>
                    <th class="th-item">Sales Order Id</th>
                    <th class="th-note">Client Name</th>
                    <th class="th-item">Address</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-primary" id="transaction_id" data-toggle="modal" data-target="#modal-sales-order">Add Sales Order</button>
    </div>
    <div class="invalid-feedback">Data invalid.</div>
</div>

<hr class="my-4">
<div class="row">
    <div class="col-sm-6 text-left">
        <button id="button-delete" class="btn btn-danger" type="button">Cancel</button>
    </div>
    <div class="col-sm-6 text-right">
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</div>