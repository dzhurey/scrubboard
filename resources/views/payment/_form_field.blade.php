<h2 class="c-form--title">Transaction Data</h2>
<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="sales_invoice_id">Sales Invoice ID</label>
                    <input class="form-control cursor-pointer" id="payment-sales-invoice-id" name="sales_invoice_id" required readonly placeholder="Sales Invoices ID" />
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modal-sales-invoices-payment">Add Sales Invoice</button>
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
    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-add-payment-means" id="add-payment-means">
        <i class="fa fa-plus"></i> Add payment means
    </a>
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
            <label class="c-form--label" for="total-amount">Total Amount</label>
            <div class="input-group flex-nowrap">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input class="form-control" id="total-amount" name="total-amount" required disabled readonly>
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

<div id="modal-add-payment-means" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="modal-add-form-payment-means" class="needs-validation">
                <div class="modal-header">
                    <h2 class="modal-title">Add payment means</h2>
                </div>
                <div class="modal-body">
                    <div class="row payment-means">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="c-form--label" for="payment_method">Payment Method</label>
                                <select class="form-control" id="payment_method" name="payment_method" required>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="bebemoney">Bebemoney</option>
                                </select>
                                <div class="invalid-feedback">Data invalid.</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="c-form--label" for="payment_type">Payment Type</label>
                                <select class="form-control" id="payment_type" name="payment_type" required>
                                    <option value="down_payment">Booking Fee</option>
                                    <option value="acquittance">Acquittance</option>
                                </select>
                                <div class="invalid-feedback">Data invalid.</div>
                            </div>
                            <div id="field-transfer">
                                <div class="form-group">
                                    <label class="c-form--label" for="transaction_date">Transfer Date</label>
                                    <input class="form-control datetimepicker" id="transaction_date" name="transaction_date" required>
                                </div>
                                <div class="form-group">
                                    <label class="c-form--label" for="bank_account">Bank Account</label>
                                    <select class="form-control" id="bank_account" name="bank_account" required>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="c-form--label" for="receiver_name">Account holder</label>
                                    <input type="text" class="form-control" id="receiver_name" name="receiver_name" required />
                                </div>
                            </div>
                            <div id="field-credit-card">
                                <div class="form-group">
                                    <label class="c-form--label" for="credit_card">Credit Card No</label>
                                    <input class="form-control" id="credit_card" name="credit_card" required>
                                </div>
                                <div class="form-group">
                                    <label class="c-form--label" for="bank_name">Bank Name</label>
                                    {{
                                        Form::select('bank_id', $banks, !empty($bank_account->id) ? $bank_account->bank_id : old('bank_id'), ['class' => 'form-control'])
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="c-form--label" for="amount">Amount</label>
                                <div class="input-group flex-nowrap">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input class="form-control" id="amount" name="amount" required>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="c-form--label" for="paid">Paid</label>
                                <input class="form-control" id="paid" name="paid" required disabled readonly>
                            </div>
                            <div class="form-group">
                                <label class="c-form--label" for="balance_due">Balance Due</label>
                                <input class="form-control" id="balance_due" name="balance_due" required disabled readonly>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>