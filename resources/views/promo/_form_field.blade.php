{{ csrf_field() }}
<div class="row">
    <div class="col-sm-6">
        <h2 class="c-form--title">Promo Data</h2>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="type">Type</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="promo">Promo</option>
                        <option value="bebemoney">Bebemoney</option>
                    </select>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="promo_name">Promo name</label>
            <input class="form-control" id="promo_name" name="name" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="promo_code">Promo code</label>
                    <input class="form-control" id="promo_code" name="code" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="c-form--label" for="promo_quota">Promo quota</label>
                    <input class="form-control" id="promo_quota" name="quota" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="promo_percentage">Promo percentage (%)</label>
                    <input class="form-control" id="promo_percentage" name="percentage" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="promo_maximum">Maximum discount</label>
                    <input class="form-control" id="promo_maximum" name="max_promo" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="start_date">Start date</label>
                    <input class="form-control datetimepicker" id="start_date" name="start_promo" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="end_date">End date</label>
                    <input class="form-control datetimepicker" id="end_date" name="end_promo" required>
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