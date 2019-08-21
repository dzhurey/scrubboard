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
    <table class="c-table table table-striped">
        <thead>
            <tr>
                <th class="th-item">Item</th>
                <th class="th-note">Notes</th>
                <th class="th-qty">Qty</th>
                <th class="th-dcs">Disc (%)</th>
                <th class="th-price">Unit Price</th>
                <th class="th-total">Total</th>
                <th class="th-action"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control select2 select2-hidden-accessible" required="" data-select2-id="3" tabindex="-1" aria-hidden="true">
                        <option></option>
                        <option value="I681239" data-select2-id="5">I681239 - Single seat stroller</option>
                    </select>
                </td>
                <td>
                    <input class="form-control">
                </td>
                <td>
                    <input class="form-control" required="" value="1">
                </td>
                <td>
                    <input class="form-control" required="" value="0">
                </td>
                <td>
                    <input class="form-control" readonly="" value="Rp. 100.000">
                </td>
                <td>
                    <input class="form-control" readonly="" value="Rp. 100.000">
                </td>
                <td class="align-middle">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#confirm">
                        <img src="./../../../assets/images/icons/trash.svg" alt="trash" width="16">
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <select class="form-control select2 select2-hidden-accessible" required="" data-select2-id="6" tabindex="-1" aria-hidden="true">
                        <option></option>
                        <option value="I681239" data-select2-id="8">I681239 - Single seat stroller</option>
                    </select>
                </td>
                <td>
                    <input class="form-control">
                </td>
                <td>
                    <input class="form-control" required="" value="1">
                </td>
                <td>
                    <input class="form-control" required="" value="0">
                </td>
                <td>
                    <input class="form-control" readonly="" value="Rp. 100.000">
                </td>
                <td>
                    <input class="form-control" readonly="" value="Rp. 100.000">
                </td>
                <td class="align-middle">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#confirm">
                        <img src="./../../../assets/images/icons/plus.svg" alt="trash" width="16">
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="note">Note</label>
            <textarea class="form-control" id="note" rows="6"></textarea>
        </div>
    </div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
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
        <div class="dropdown d-inline-block mr-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Copy to
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">AR Invoice</a>
                <a class="dropdown-item" href="#">A/R DP Invoice</a>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</div>