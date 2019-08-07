{{ csrf_field() }}
<form class="c-form needs-vlidation" novalidate 
    method="POST" action="{{ route('customers.store') }}">
    <div class="row">
        <div class="col-sm-6">
            <h2 class="c-form--title">Personal Data</h2>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="business-partner">Business Partner</label>
                        {{ 
                            Form::select('partner_type',
                            App\Customer::PARTNER_TYPE, 
                            !empty($customer->id) ? $customer->partner_type : old('partner_type'), 
                            [
                                'id' => 'business-partner',
                                'class' => 'form-control',
                                'required'
                            ])
                        }}
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="c-form--label" for="name">Name</label>
                <input class="form-control" id="name" name="name" 
                    value="{{ !empty($customer->id) ? $customer->name : old('name') }}" required>
                <div class="invalid-feedback">Data invalid.</div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="birthday">Birthday</label>
                        <input class="form-control datetimepicker" id="birthday" name="birth_date" 
                            value="{{ !empty($customer->id) ? $customer->birth_date : old('birth_date') }}" required>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="gender">Gender</label>
                        
                        <div class="mt-1" id="gender">
                        @foreach(App\Customer::GENDERS as $gender)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input form-check-radio" id="{{ $gender }}" type="radio" name="gender" 
                                    value="{{ $gender }}" required
                                    {{ !empty($customer->id) && $customer->gender == $gender ? "checked" : "" }}>
                                <label class="form-check-label" for="{{ $gender }}">{{ ucfirst(trans($gender)) }}</label>
                            </div>
                        @endforeach
                        </div>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="c-form--label" for="religion">Religion</label>
                {{ 
                    Form::select('religion',
                    App\Customer::RELIGIONS, 
                    !empty($customer->id) ? $customer->religion : old('religion'), 
                    [
                        'id' => 'religion',
                        'class' => 'form-control',
                        'required'
                    ]) 
                }}
                <div class="invalid-feedback">Data invalid.</div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="telephone">Telephone</label>
                        <input class="form-control" id="telephone" name="phone_number" 
                            value="{{ !empty($customer->id) ? $customer->phone_number : old('phone_number') }}" required>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" 
                            value="{{ !empty($customer->id) ? $customer->email : old('email') }}" required>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <h2 class="c-form--title">Bebe’s Data</h2>
            <div class="form-group">
                <label class="c-form--label" for="bebes-name">Bebe's name</label>
                <input class="form-control" id="bebes-name" name="bebe_name" 
                    value="{{ !empty($customer->id) ? $customer->bebe_name : old('bebe_name') }}" required>
                <div class="invalid-feedback">Data invalid.</div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="bebe-birthday">Bebe's birthday</label>
                        <input class="form-control datetimepicker" id="bebe-birthday" name="bebe_birth_date" 
                            value="{{ !empty($customer->id) ? $customer->bebe_birth_date : old('bebe_birth_date') }}" required>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="bebes-gender">Bebe's gender</label>
                        <div class="mt-1" id="bebes-gender">
                        @foreach(App\Customer::GENDERS as $gender)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input form-check-radio" id="{{ $gender.'-bebe' }}" type="radio" name="bebe_gender" 
                                    value="{{ $gender }}" required
                                    {{ !empty($customer->id) && $customer->bebe_gender == $gender ? "checked" : "" }}>
                                <label class="form-check-label" for="{{ $gender.'-bebe' }}">{{ ucfirst(trans($gender)) }}</label>
                            </div>
                        @endforeach
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
                <label class="c-form--label" for="address">Address</label>
                <textarea class="form-control" id="address" name="billing_address">
                    {{ !empty($customer->id) ? $customer->billingAddress()->description : old('billing_address') }}
                </textarea>
                <div class="invalid-feedback">Data invalid.</div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="billing_district">District</label>
                        <input class="form-control" id="billing_district" name="billing_district" 
                            value="{{ !empty($customer->id) ? $customer->billingAddress()->district : old('billing_district') }}" required>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="billing_city">City</label>
                        <input class="form-control" id="billing_city" name="billing_city" 
                            value="{{ !empty($customer->id) ? $customer->billingAddress()->city : old('billing_city') }}" required>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="billing_country">Country</label>
                        <input class="form-control" id="billing_country" name="billing_country"
                            value="{{ !empty($customer->id) ? $customer->billingAddress()->country : old('billing_country') }}" required>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="c-form--label" for="billing_zip_code">Zip code</label>
                        <input class="form-control" id="billing_zip_code" name="billing_zip_code" 
                            value="{{ !empty($customer->id) ? $customer->billingAddress()->zip_code : old('billing_zip_code') }}" required>
                        <div class="invalid-feedback">Data invalid.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group" style="margin-top: -12px">
                <div class="mt-1" id="shipping">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input form-check-box" id="is_same_address" type="checkbox" name="is_same_address"
                            {{ !empty($customer->id) && $customer->billingAddress()->is_shipping ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_same_address">Address and shipping information are the same</label>
                    </div>
                </div>
            </div>
            <div id="is_same_address_content">
                <div class="form-group">
                    <label class="c-form--label" for="address">Address</label>
                    <textarea class="form-control" id="address" name="shipping_address">
                        {{ !empty($customer->id) ? $customer->shippingAddress()->description : old('shipping_address') }}
                    </textarea>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="c-form--label" for="shipping_district">District</label>
                            <input class="form-control" id="shipping_district" name="shipping_district" 
                                value="{{ !empty($customer->id) ? $customer->shippingAddress()->district : old('shipping_district') }}">
                            <div class="invalid-feedback">Data invalid.</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="c-form--label" for="shipping_city">City</label>
                            <input class="form-control" id="shipping_city" name="shipping_city" 
                                value="{{ !empty($customer->id) ? $customer->shippingAddress()->city : old('shipping_city') }}">
                            <div class="invalid-feedback">Data invalid.</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="c-form--label" for="shipping_country">Country</label>
                            <input class="form-control" id="shipping_country" name="shipping_country" 
                                value="{{ !empty($customer->id) ? $customer->shippingAddress()->country : old('shipping_country') }}">
                            <div class="invalid-feedback">Data invalid.</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="c-form--label" for="shipping_zip_code">Zip code</label>
                            <input class="form-control" id="shipping_zip_code" name="shipping_zip_code" 
                                value="{{ !empty($customer->id) ? $customer->shippingAddress()->zip_code : old('shipping_zip_code') }}">
                            <div class="invalid-feedback">Data invalid.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-4">
    <div class="text-right">
        <button class="btn btn-light mr-2" type="button">Cancel</button>
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</form>

