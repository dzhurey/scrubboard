<div class="row">
    <div class="col-sm-6">
        <h2 class="c-form--title">Personal Data</h2>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="business-partner">Business Partner</label>
                    <select class="form-control" id="business-partner" name="partner_type" required="">
                        <option value="customer">Customer</option>
                        <option value="endorser">Endorser</option>
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
                    <label class="c-form--label" for="birthday">Birthday</label>
                    <input class="form-control datetimepicker" id="birth_date" name="birth_date">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="gender">Gender</label>
                    
                    <div class="mt-1" id="gender">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-radio" id="gender_male" type="radio" name="gender" 
                                value="male" required>
                            <label class="form-check-label" for="gender_male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-radio" id="gender_female" type="radio" name="gender" 
                                value="female" required>
                            <label class="form-check-label" for="gender_female">Female</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="religion">Religion</label>
            <select id="religion" class="form-control" name="religion">
                <option value=""></option>
                <option value="islam">Islam</option>
                <option value="christian">Kristen</option>
                <option value="catholic">Katolik</option>
                <option value="hindu">Hindu</option>
                <option value="buddhis">Budha</option>
                <option value="kong hu chu">Kong Hu Chu</option>
            </select>
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
                    <label class="c-form--label" for="email">Email</label>
                    <input class="form-control" id="email" name="email">
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h2 class="c-form--title">Bebe’s Data</h2>
        <div class="form-group">
            <label class="c-form--label" for="bebes-name">Bebe's name</label>
            <input class="form-control" id="bebes-name" name="bebe_name">
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="bebe-birthday">Bebe's birthday</label>
                    <input class="form-control datetimepicker" id="bebe-birthday" name="bebe_birth_date">
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="bebes-gender">Bebe's gender</label>
                    <div class="mt-1" id="bebes-gender">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-radio" id="bebe_gender_male" type="radio" name="bebe_gender" 
                                value="male">
                            <label class="form-check-label" for="bebe_gender_male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input form-check-radio" id="bebe_gender_female" type="radio" name="bebe_gender" 
                                value="female">
                            <label class="form-check-label" for="bebe_gender_female">Female</label>
                        </div>
                    </div>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-sm-6">
        <h2 class="c-form--title">Address</h2>
        <div class="form-group">
            <label class="c-form--label" for="billing_address">Address</label>
            <textarea class="form-control" id="billing_address" name="billing_address"></textarea>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="billing_district">District</label>
                    <input class="form-control" id="billing_district" name="billing_district" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="billing_city">City</label>
                    <input class="form-control" id="billing_city" name="billing_city" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="billing_country">Country</label>
                    <input class="form-control" id="billing_country" name="billing_country" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" for="billing_zip_code">Zip code</label>
                    <input class="form-control" id="billing_zip_code" name="billing_zip_code" required>
                    <div class="invalid-feedback">Data invalid.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group" style="margin-top: -12px">
            <div class="mt-1" id="shipping">
                <div class="form-check form-check-inline">
                    <input class="form-check-input form-check-box" id="is_same_address" type="checkbox" name="is_same_address">
                    <label class="form-check-label" for="is_same_address">Address and shipping information are the same</label>
                </div>
            </div>
        </div>
        <div id="is_same_address_content">
            <div class="form-group">
                <label class="c-form--label" for="shipping_address">Address</label>
                <textarea class="form-control" id="shipping_address" name="shipping_address"></textarea>
                <div class="invalid-feedback">Data invalid.</div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="shipping_district">District</label>
                        <input class="form-control" id="shipping_district" name="shipping_district">
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="shipping_city">City</label>
                        <input class="form-control" id="shipping_city" name="shipping_city">
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="shipping_country">Country</label>
                        <input class="form-control" id="shipping_country" name="shipping_country">
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="shipping_zip_code">Zip code</label>
                        <input class="form-control" id="shipping_zip_code" name="shipping_zip_code">
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <h2 class="c-form--title mt-5">Assign price list</h2>
        <div class="form-group">
            <label class="c-form--label" for="price_list">Price list</label>
            <select class="form-control" id="price_list" name="price_id" required></select>
            <div class="invalid-feedback">Data invalid.</div>
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