<h2 class="c-form--title">Transaction Data</h2>
<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="sales_invoice_id">Sales Invoice ID</label>
                    <input class="form-control cursor-pointer" id="payment-sales-invoice-id" name="sales_invoice_id" required readonly placeholder="Sales Invoices ID" />
                    <button type="button" id="button-choose-invoices" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modal-sales-invoices-payment">Add Sales Invoice</button>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="date">Date</label>
                    <input class="form-control datetimepicker" id="date" name="date" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="customer-name">Client Name</label>
                    <input class="form-control" id="customer-name" name="customer-name" required disabled readonly>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="transaction_type">Trasanction Type</label>
                    <input class="form-control" id="transaction_type" name="transaction_type" required disabled readonly>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<h2 class="c-form--title mt-4">Payment Means</h2>
<div class="c-table--outer mx-0">
    <div class="table-responsive adjust-width">
        <table id="table-payment-lines" class="c-table table table-striped">
            <thead>
                <tr>
                    <th class="th-item">Payment Method</th>
                    <th class="th-item">Payment Type</th>
                    <th class="th-item">Bank Account</th>
                    <th class="th-item">Account holder</th>
                    <th class="th-item">Credit Card No.</th>
                    <th class="th-item">Bank Name</th>
                    <th class="th-item text-right">Amount</th>
                    <th class="th-item">Note</th>
                    <th class="th-action"></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="text-right">
    <button type="button"
        data-toggle="modal" data-target="#modal-add-payment-means"
        id="add-payment-means" class="btn btn-primary disabled" disabled>
        <i class="fa fa-plus"></i> Add payment means
    </button>
</div>

<div class="row mt-4">
    <div class="col-sm-6">
        <div class="form-group">
            <label class="c-form--label" for="note">Note</label>
            <textarea class="form-control" id="note" rows="5"></textarea>
        </div>
    </div>
    <div class="col-sm-4 offset-sm-2">
        <div class="form-group">
            <label class="c-form--label" for="total-amount">Due Balance</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="amount" name="amount" required disabled readonly>
            </div>
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