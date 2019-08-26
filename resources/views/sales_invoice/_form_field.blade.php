<div class="row mb-4">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="sales_order_origin">Sales Order</label>
            <select class="form-control select2" id="sales_order_id" name="sales_order_id" required>
                <option></option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
    </div>
</div>

<hr class="my-4 mb-5">

<h2 class="c-form--title">Invoice Data</h2>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="order_type">Order type</label>
            <select class="form-control" id="order_type" name="order_type" required disabled>
                <option value="general">General</option>
                <option value="endorser">Endorser</option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="customer_id">Customer</label>
            <select class="form-control select2" id="customer_id" name="customer_id" required disabled>
                <option></option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="outlet">Outlet</label>
            <select class="form-control select2" id="outlet" name="outlet" required disabled>
                <option></option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
    </div>
    <div class="col-sm-2"></div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="status_order">Status order</label>
                    <input class="form-control" id="status_order" name="status_order" readonly>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="transaction_date">Document date</label>
                    <input class="form-control datetimepicker" id="transaction_date" name="transaction_date" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="pickup_date">Pick Up date</label>
                    <input class="form-control datetimepicker" id="pickup_date" name="pickup_date" required readonly>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="delivery_date">Delivery date</label>
                    <input class="form-control datetimepicker" id="delivery_date" name="delivery_date" required readonly>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="c-table--outer mx-0">
    <table id="table-so-item" class="c-table table table-striped">
        <thead>
            <tr>
                <th class="th-item">Item</th>
                <th class="th-note">Notes</th>
                <th class="th-qty text-right">Qty</th>
                <th class="th-dcs text-right">Disc (%)</th>
                <th class="th-price text-right">Unit Price</th>
                <th class="th-total text-right">Total</th>
                <th class="th-action"></th>
            </tr>
        </thead>
    </table>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="note">Note</label>
            <textarea class="form-control" id="note" rows="6" readonly></textarea>
        </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="col-sm-5">
        <div class="form-group">
            <label class="c-form--label" for="original_amount">Total Before Discount</label>
            <input class="form-control" id="original_amount" value="0" readonly>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="c-form--label" for="discount">Discount %</label>
                    <input class="form-control" id="discount" value="0">
                </div>
            </div>
            <div class="col-sm-9">
                <div class="form-group">
                    <label class="c-form--label" for="discount_amount">Amount Discount</label>
                    <input class="form-control" id="discount_amount" value="0" readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="freight">Freight</label>
            <input class="form-control" id="freight" value="0">
        </div>
        <div class="form-group">
            <label class="c-form--label" for="total_amount">Total</label>
            <input class="form-control" id="total_amount" value="0" readonly>
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