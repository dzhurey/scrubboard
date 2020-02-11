<h2 class="c-form--title">Sales Order Data</h2>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input form-check-box" id="is_pre_order" type="checkbox" name="is_pre_order">
                <label class="form-check-label" for="is_pre_order">Pre Order</label>
            </div>
        </div>
        <div id="user_name" class="form-group">
            <label class="c-form--label" for="user_id">Author</label>
            <input class="form-control cursor-pointer" id="user_id" name="user_id" readonly />
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="order_type">Order type</label>
            <select class="form-control" id="order_type" name="order_type" required>
                <option value="general">General</option>
                <option value="endorser">Endorser</option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="customer_id">Client Name</label>
            <input class="form-control cursor-pointer" id="customer_id" name="customer_id" required readonly placeholder="Pilih Client" data-toggle="modal" data-target="#modal-customer" />
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="agent_id">POS</label>
            <select class="form-control select2" id="agent_id" name="agent_id" required>
                <option></option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input form-check-box is-reverse" id="is_own_address" type="checkbox" name="is_own_address" checked>
                <label class="form-check-label" for="is_own_address">Pickup at outlet</label>
            </div>
        </div>
    </div>
    <div class="col-sm-2"></div>
    <div class="col-sm-6">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="status_order">Status order</label>
                    <input class="form-control" id="status_order" name="status_order" disabled value="Open">
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
            <div class="col-sm-6 d-none">
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
                    <th id="th-disc" class="th-dcs text-right">Disc</th>
                    <th class="th-total text-right">Total</th>
                    <th class="th-note">Notes</th>
                    <th class="th-action"></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <button type="button" id="btn-add-item" class="btn btn-primary disabled" data-toggle="modal" data-target="#modal-price" disabled>Add Item</button>
        </div>
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
                <input class="form-control is-number" id="original_amount" value="0" readonly>
            </div>
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
                    <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input class="form-control is-number" id="discount_amount" value="0">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="freight">Freight</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control is-number" id="freight" value="0">
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="total_amount">Total</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control is-number" id="total_amount" value="0" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="dp_amount">Booking Fee</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control is-number" id="dp_amount" value="0">
            </div>
        </div>
    </div>
</div>

<hr class="my-4">
<div class="row">
    <div class="col-sm-6 text-left">
        <button id="button-delete" class="btn btn-danger" type="button">Cancel Document</button>
        <button id="btn-download" class="btn btn-default btn-sm" type="button">
            <i class="fa fa-download"></i>&nbsp;Download proforma
        </button>
    </div>
    <div class="col-sm-6 text-right">
        <button id='button-cancel' class="btn btn-light mr-2" type="button">Cancel</button>
        <!-- @if(!empty($sales_order))
        <div class="dropdown d-inline-block mr-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Copy to
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('sales_invoices.create', ['from_order' => $sales_order->id]) }}">AR Invoice</a>
            </div>
        </div>
        @endif -->
        <button id="form-submit" class="btn btn-primary" type="submit">Submit</button>
    </div>
</div>