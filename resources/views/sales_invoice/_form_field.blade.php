<div id="logo-print" class="d-none mb-5">
    <img class="logo-full" src="{{ asset('assets/images/logo-bebewash.png') }}" height="70">
</div>

<div class="row mb-4">
    <div class="col-sm-4">
        <div class="form-group">
            <label id="invoice-number" class="c-form--label" for="order_id">Sales Order</label>
            <input class="form-control cursor-pointer" id="order_id" name="order_id" required readonly placeholder="Sales Order ID" /><button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modal-sales-order-on-invoice">Add Sales Order</button>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
    </div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4 text-right">
        <button id="btn-print" class="btn btn-primary btn-sm" type="button">
            <i class="fa fa-print"></i>&nbsp;Print Invoice
        </button>
    </div>
</div>

<hr class="my-4 mb-5">

<h2 class="c-form--title">Invoice Data</h2>
<div id="inv-data" class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="order_type">Order type</label>
            <input class="form-control cursor-pointer" id="order_type" name="order_type" required readonly placeholder="Order Type" />
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="customer_id">Client</label>
            <input class="form-control cursor-pointer" id="customer_id" name="customer_id" required readonly placeholder="Client Name" />
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div id="pos-outlet" class="form-group">
            <label class="c-form--label" for="agent_outlet">POS</label>
            <input class="form-control cursor-pointer" id="agent_outlet" name="agent_outlet" required readonly placeholder="POS Name" />
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div id="pickup-outlet" class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input form-check-box is-reverse" id="is_own_address" type="checkbox" name="is_own_address" checked readonly>
                <label class="form-check-label" for="is_own_address">Deliver to outlet</label>
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
    <div class="col-sm-6">
        <div class="row">
            <div id="status--order" class="col-sm-6">
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
            <div id="pickup-date" class="col-sm-6 d-none">
                <div class="form-group">
                    <label class="c-form--label" for="pickup_date">Pick Up date</label>
                    <input class="form-control datetimepicker" id="pickup_date" name="pickup_date" required readonly>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div id="delivery--date" class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="delivery_date">Delivery date</label>
                    <input class="form-control datetimepicker" id="delivery_date" name="delivery_date" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div id="due--date" class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="due_date">Due date</label>
                    <input class="form-control datetimepicker" id="due_date" name="due_date" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="c-table--outer mx-0">
    <div class="table-responsive">
        <table id="table-so-item" class="c-table table table-striped">
            <thead>
                <tr>
                    <th class="th-item">Item</th>
                    <th class="th-price">BOR<span style="color: red">&nbsp;*</span></th>
                    <th class="th-note">Brand</th>
                    <th class="th-price">Color</th>
                    <th class="th-total">Code/Promo</th>
                    <th class="th-qty text-right">Qty</th>
                    <th class="th-price text-right">Unit Price</th>
                    <th class="th-dcs text-right">Disc (%)</th>
                    <th class="th-total text-right">Total</th>
                    <th class="th-note">Notes</th>
                    <th class="th-action"></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="foot-note" class="row">
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
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="original_amount" value="0" readonly>
            </div>
        </div>
        <div class="row">
            <div id="discount-percent" class="col-sm-3">
                <div class="form-group">
                    <label class="c-form--label" for="discount">Discount %</label>
                    <input class="form-control" id="discount" value="0" readonly>
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
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="freight" value="0">
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="total_amount">Total</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="total_amount" value="0" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="total_amount">Total DP</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="dp_amount" value="0">
            </div>
        </div>
    </div>
</div>

<div id="footer-form">
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
</div>