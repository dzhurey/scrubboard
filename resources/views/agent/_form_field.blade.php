<div class="row">
    <div class="col-sm-6">
        <h2 class="c-form--title">Outlet Data</h2>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="agent_group_id">Outlet type</label>
                    <select class="form-control" id="agent_group_id" name="agent_group_id" required>
                        <option value="1">Agent</option>
                    </select>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="name">Name</label>
            <input class="form-control" id="name" name="name" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="phone_number">Telephone</label>
                    <input class="form-control" id="phone_number" name="phone_number" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="mobile_number">Mobile Phone</label>
                    <input class="form-control" id="mobile_number" name="mobile_number" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="email">Email</label>
            <input class="form-control" id="email" name="email">
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-sm-6">
        <h2 class="c-form--title">Address</h2>
        <div class="form-group">
            <label class="c-form--label" for="address">Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="sub_district">Sub District</label>
                    <input class="form-control" id="sub_district" name="sub_district" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="district">District</label>
                    <input class="form-control" id="district" name="district" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="city">City</label>
                    <input class="form-control" id="city" name="city" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="country">Country</label>
                    <input class="form-control" id="country" name="country" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="zip_code">Zip Code</label>
                    <input class="form-control" id="zip_code" name="zip_code" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h2 class="c-form--title">Contact Person</h2>
        <div class="form-group">
            <label class="c-form--label" for="contact_name">Name</label>
            <input class="form-control" id="contact_name" name="contact_name" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="contact_phone_number">Telephone</label>
                    <input class="form-control" id="contact_phone_number" name="contact_phone_number" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="contact_mobile_number">Mobile Phone</label>
                    <input class="form-control" id="contact_mobile_number" name="contact_mobile_number" required>
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