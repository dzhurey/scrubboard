<div class="row">
    <div class="col-sm-6">
        <h2 class="c-form--title">Bank Data</h2>
        <div class="form-group">
            <label class="c-form--label" for="name">Nama</label>
            <input class="form-control" id="name" name="name" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="bank">Bank name</label>
                    {{ 
                        Form::select('bank_id', $banks, !empty($bank_account->id) ? $bank_account->bank_id : old('bank_id'), ['class' => 'form-control']) 
                    }}
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="account-number">Account number</label>
                    <input class="form-control" name="account_number" id="account-number" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
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