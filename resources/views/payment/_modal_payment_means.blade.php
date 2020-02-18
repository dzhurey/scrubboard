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
                          <label class="c-form--label" for="date">Payment Date</label>
                          <input class="form-control datetimepicker" id="payment_date" name="payment_date" required>
                          <div class="invalid-feedback">Data invalid.</div>
                        </div>
                      </div>
                    </div>
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
                                    <select class="form-control" id="bank_account" name="bank_account">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="c-form--label" for="receiver_name">Account holder</label>
                                    <input type="text" class="form-control" id="receiver_name" name="receiver_name"/>
                                </div>
                            </div>
                            <div id="field-credit-card">
                                <div class="form-group">
                                    <label class="c-form--label" for="credit_card">Credit Card No</label>
                                    <input class="form-control" id="credit_card" name="credit_card">
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
                                    <input class="form-control" id="total_amount" name="amount" required>
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
            <input id="list-banks" hidden value="{{ json_encode($banks) }}"/>
        </div>
    </div>
</div>
