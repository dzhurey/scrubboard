<div class="row">
    <div class="col-sm-6">
        <h2 class="c-form--title">Courier Data</h2>
        <div class="form-group">
            <label class="c-form--label" for="name">Nama</label>
            <input class="form-control" id="name" type="text" name="name" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="email">Email</label>
            <input class="form-control" id="email" type="text" name="email" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="username">Username</label>
            <input class="form-control" id="username" type="text" name="username" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="role">Role</label>
            <select class="form-control" id="role" name="role">
                <option value="courier">Courier</option>
            </select>
        </div>
        <div id="button-change-password" class="form-group">
            <button class="btn btn-primary btn-sm" type="button">Change password</button>
        </div>
        <div id="form-change-password">
            <div class="form-group">
                <label class="c-form--label" for="password">Password</label>
                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" value="{{ old('password') }}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label class="c-form--label" for="confirm_password">Konfirmasi Password</label>
                <input class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" type="password" name="confirm_password" value="{{ old('password') }}">
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="form-group">
            <label class="c-form--label" for="phone_number">No. Handphone</label>
            <input class="form-control" id="phone_number" type="text" name="phone_number" required>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="c-form--label" id="birthday">Tanggal Lahir</label>
                    <input class="form-control datetimepicker @error('birth_date') is-invalid @enderror" id="birthday" name="birth_date" required>
                    <div class="invalid-feedback">Data invalid.</div>
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

        <h2 class="c-form--title mt-5">User Address</h2>
        <div class="form-group">
            <label class="c-form--label" for="address">Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
            <div class="invalid-feedback">Data invalid.</div>
        </div>
        <div class="row">
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
                    <label class="c-form--label" for="zip_code">Zip code</label>
                    <input class="form-control" id="zip_code" name="zip_code" required>
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