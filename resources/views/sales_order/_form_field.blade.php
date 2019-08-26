<h2 class="c-form--title">Sales Order Data</h2>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="order_type">Order type</label>
            <select class="form-control" id="order_type" name="order_type" required>
                <option value="general">General</option>
                <option value="endorser">Endorser</option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="customer_id">Customer</label>
            <select class="form-control select2" id="customer_id" name="customer_id" required>
                <option></option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="outlet">Outlet</label>
            <select class="form-control select2" id="outlet" name="outlet" required>
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
                    <input class="form-control" id="status_order" name="status_order" disabled>
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
                    <input class="form-control datetimepicker" id="pickup_date" name="pickup_date" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="delivery_date">Delivery date</label>
                    <input class="form-control datetimepicker" id="delivery_date" name="delivery_date" required>
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
                <th class="th-price">BOR</th>
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
            <textarea class="form-control" id="note" rows="6"></textarea>
        </div>
    </div>
    <div class="col-sm-3"></div>
    <div class="col-sm-5">
        <div class="form-group">
            <label class="c-form--label" for="original_amount">Total Before Discount</label>
            <input class="form-control is-number" id="original_amount" value="0" readonly>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="c-form--label" for="discount">Discount %</label>
                    <input class="form-control is-number" id="discount" value="0">
                </div>
            </div>
            <div class="col-sm-9">
                <div class="form-group">
                    <label class="c-form--label" for="discount_amount">Amount Discount</label>
                    <input class="form-control is-number" id="discount_amount" value="0" readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="freight">Freight</label>
            <input class="form-control is-number" id="freight" value="0">
        </div>
        <div class="form-group">
            <label class="c-form--label" for="total_amount">Total</label>
            <input class="form-control is-number" id="total_amount" value="0" readonly>
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
        <div class="dropdown d-inline-block mr-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Copy to
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('sales_invoices.create', ['from_order' => $sales_order->id]) }}">AR Invoice</a>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</div>