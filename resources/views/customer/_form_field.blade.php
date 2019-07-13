{{ csrf_field() }}
<div class="form-group">
    <label>Partner type</label>
    {{ Form::select('partner_type', App\Customer::PARTNER_TYPE, !empty($customer->id) ? $customer->partner_type : old('partner_type'), ['class' => 'form-control'.($errors->has('partner_type') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('partner_type'))
        <div class="invalid-feedback">{{ $errors->first('partner_type') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Nama</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ !empty($customer->id) ? $customer->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Email</label>
    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ !empty($customer->id) ? $customer->email : old('email') }}" @if(!empty($customer->id)) disabled @endif>
    @if ($errors->has('email'))
        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
    @endif
</div>
<div class="form-group">
    <label>No. Handphone</label>
    <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" value="{{ !empty($customer->id) ? $customer->phone_number : old('phone_number') }}">
    @if ($errors->has('phone_number'))
        <div class="invalid-feedback">{{ $errors->first('phone_number') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Tanggal Lahir</label>
    <input class="form-control @error('birth_date') is-invalid @enderror" type="date" name="birth_date" value="{{ !empty($customer->id) ? $customer->birth_date : old('birth_date') }}">
    @if ($errors->has('birth_date'))
        <div class="invalid-feedback">{{ $errors->first('birth_date') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Gender</label>
    {{ Form::select('gender', App\Customer::GENDERS, !empty($customer->id) ? $customer->gender : old('gender'), ['class' => 'form-control'.($errors->has('gender') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('gender'))
        <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Agama</label>
    {{ Form::select('religion', App\Customer::RELIGIONS, !empty($customer->id) ? $customer->religion : old('religion'), ['class' => 'form-control'.($errors->has('religion') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('religion'))
        <div class="invalid-feedback">{{ $errors->first('religion') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Nama Bebe</label>
    <input class="form-control @error('bebe_name') is-invalid @enderror" type="text" name="bebe_name" value="{{ !empty($customer->id) ? $customer->bebe_name : old('bebe_name') }}">
    @if ($errors->has('bebe_name'))
        <div class="invalid-feedback">{{ $errors->first('bebe_name') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Tanggal Lahir Bebe</label>
    <input class="form-control @error('bebe_birth_date') is-invalid @enderror" type="date" name="bebe_birth_date" value="{{ !empty($customer->id) ? $customer->bebe_birth_date : old('bebe_birth_date') }}">
    @if ($errors->has('bebe_birth_date'))
        <div class="invalid-feedback">{{ $errors->first('bebe_birth_date') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Gender Bebe</label>
    {{ Form::select('bebe_gender', App\Customer::GENDERS, !empty($customer->id) ? $customer->bebe_gender : old('bebe_gender'), ['class' => 'form-control'.($errors->has('bebe_gender') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('bebe_gender'))
        <div class="invalid-feedback">{{ $errors->first('bebe_gender') }}</div>
    @endif
</div>
<div class="row">
    <div class="col">
        <b>Alamat Pelanggan</b>
        <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control @error('billing_address') is-invalid @enderror" name="billing_address">{{ !empty($customer->id) ? $customer->billingAddress()->description : old('billing_address') }}</textarea>
            @if ($errors->has('billing_address'))
                <div class="invalid-feedback">{{ $errors->first('billing_address') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label>Kecamatan</label>
            <input class="form-control @error('billing_district') is-invalid @enderror" type="text" name="billing_district" value="{{ !empty($customer->id) ? $customer->billingAddress()->district : old('billing_district') }}">
            @if ($errors->has('billing_district'))
                <div class="invalid-feedback">{{ $errors->first('billing_district') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label>Kota</label>
            <input class="form-control @error('billing_city') is-invalid @enderror" type="text" name="billing_city" value="{{ !empty($customer->id) ? $customer->billingAddress()->city : old('billing_city') }}">
            @if ($errors->has('billing_city'))
                <div class="invalid-feedback">{{ $errors->first('billing_city') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label>Negara</label>
            <input class="form-control @error('billing_country') is-invalid @enderror" type="text" name="billing_country" value="{{ !empty($customer->id) ? $customer->billingAddress()->country : old('billing_country') }}">
            @if ($errors->has('billing_country'))
                <div class="invalid-feedback">{{ $errors->first('billing_country') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label>Kode Pos</label>
            <input class="form-control @error('billing_zip_code') is-invalid @enderror" type="text" name="billing_zip_code" value="{{ !empty($customer->id) ? $customer->billingAddress()->zip_code : old('billing_zip_code') }}">
            @if ($errors->has('billing_zip_code'))
                <div class="invalid-feedback">{{ $errors->first('billing_zip_code') }}</div>
            @endif
        </div>
    </div>
    <div class="col">
        <b>Alamat Pengiriman</b>
        <div class="form-group">
            <label>
                <input type="checkbox" name="is_same_address">
                Alamat dan alamat pengiriman sama
            </label>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address">{{ !empty($customer->id) ? $customer->shippingAddress()->description : old('shipping_address') }}</textarea>
            @if ($errors->has('shipping_address'))
                <div class="invalid-feedback">{{ $errors->first('shipping_address') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label>Kecamatan</label>
            <input class="form-control @error('shipping_district') is-invalid @enderror" type="text" name="shipping_district" value="{{ !empty($customer->id) ? $customer->shippingAddress()->district : old('shipping_district') }}">
            @if ($errors->has('shipping_district'))
                <div class="invalid-feedback">{{ $errors->first('shipping_district') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label>Kota</label>
            <input class="form-control @error('shipping_city') is-invalid @enderror" type="text" name="shipping_city" value="{{ !empty($customer->id) ? $customer->shippingAddress()->city : old('shipping_city') }}">
            @if ($errors->has('shipping_city'))
                <div class="invalid-feedback">{{ $errors->first('shipping_city') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label>Negara</label>
            <input class="form-control @error('shipping_country') is-invalid @enderror" type="text" name="shipping_country" value="{{ !empty($customer->id) ? $customer->shippingAddress()->country : old('shipping_country') }}">
            @if ($errors->has('shipping_country'))
                <div class="invalid-feedback">{{ $errors->first('shipping_country') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label>Kode Pos</label>
            <input class="form-control @error('shipping_zip_code') is-invalid @enderror" type="text" name="shipping_zip_code" value="{{ !empty($customer->id) ? $customer->shippingAddress()->zip_code : old('shipping_zip_code') }}">
            @if ($errors->has('shipping_zip_code'))
                <div class="invalid-feedback">{{ $errors->first('shipping_zip_code') }}</div>
            @endif
        </div>
    </div>
</div>