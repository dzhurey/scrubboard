<h2 class="c-form--title">Transaction Data</h2>
<div class="row">
<<<<<<< HEAD
    <div class="col-sm-8">
=======
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
            <label class="c-form--label" for="customer_id">Customer</label>
            {{
                Form::select('bank_id', $banks, !empty($bank_account->id) ? $bank_account->bank_id : old('bank_id'), ['class' => 'form-control'])
            }}
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
>>>>>>> b2ee4d883849711601b4a70579051f9fd93bcd50
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="sales_invoice_id">Sales Invoice ID</label>
                    <select class="form-control select2" id="payment-sales-invoice-id" name="sales_invoice_id" required>
                        <option></option>
                    </select>
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
                    <label class="c-form--label" for="customer-name">Customer Name</label>
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
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="c-form--label" for="note">Note</label>
                    <textarea class="form-control" id="note" rows="5"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<h2 class="c-form--title mt-4">Payment Means</h2>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="c-form--label" for="payment_method">Payment Method</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="cash">Cash</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="credit_card">Credit Card</option>
            </select>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
    </div>
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div id="field-transfer">
            <div class="form-group">
                <label class="c-form--label" for="transaction_date">Transfer Date</label>
                <input class="form-control datetimepicker" id="transaction_date" name="transaction_date" required>
            </div>
            <div class="form-group">
                <label class="c-form--label" for="bank_account">Bank Account</label>
                <select class="form-control" id="bank_account" name="bank_account" required>
                    <option></option>
                </select>
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
        <div class="form-group">
            <label class="c-form--label" for="amount">Amount</label>
            <input class="form-control" id="amount" name="amount" required>
        </div>
        <!-- <div class="form-group">
            <label class="c-form--label" for="paid">Paid</label>
            <input class="form-control" id="paid" name="paid" required disabled readonly>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="balance_due">Balance Due</label>
            <input class="form-control" id="balance_due" name="balance_due" required disabled readonly>
        </div> -->
        <div class="form-group">
            <label class="c-form--label" for="total-amount">Total Amount</label>
            <input class="form-control" id="total-amount" name="total-amount" required disabled readonly>
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