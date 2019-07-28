{{ csrf_field() }}
<div class="form-group">
    <label>Kategori Agen</label>
    {{ Form::select('agent_group_id', $agent_groups, !empty($agent->id) ? $agent->agent_group_id : old('agent_group_id'), ['class' => 'form-control'.($errors->has('agent_group_id') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('agent_group_id'))
        <div class="invalid-feedback">{{ $errors->first('agent_group_id') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Nama</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ !empty($agent->id) ? $agent->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>
<div class="form-group">
    <label>No. Telepon</label>
    <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" value="{{ !empty($agent->id) ? $agent->phone_number : old('phone_number') }}">
    @if ($errors->has('phone_number'))
        <div class="invalid-feedback">{{ $errors->first('phone_number') }}</div>
    @endif
</div>
<div class="form-group">
    <label>No. Handphone</label>
    <input class="form-control @error('mobile_number') is-invalid @enderror" type="text" name="mobile_number" value="{{ !empty($agent->id) ? $agent->mobile_number : old('mobile_number') }}">
    @if ($errors->has('mobile_number'))
        <div class="invalid-feedback">{{ $errors->first('mobile_number') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Email</label>
    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ !empty($agent->id) ? $agent->email : old('email') }}">
    @if ($errors->has('email'))
        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Alamat</label>
    <textarea class="form-control @error('address') is-invalid @enderror" name="address">{{ !empty($agent->id) ? $agent->address : old('address') }}</textarea>
    @if ($errors->has('address'))
        <div class="invalid-feedback">{{ $errors->first('address') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Kelurahan</label>
    <input class="form-control @error('sub_district') is-invalid @enderror" type="text" name="sub_district" value="{{ !empty($agent->id) ? $agent->sub_district : old('sub_district') }}">
    @if ($errors->has('sub_district'))
        <div class="invalid-feedback">{{ $errors->first('sub_district') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Kecamatan</label>
    <input class="form-control @error('district') is-invalid @enderror" type="text" name="district" value="{{ !empty($agent->id) ? $agent->district : old('district') }}">
    @if ($errors->has('district'))
        <div class="invalid-feedback">{{ $errors->first('district') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Kota</label>
    <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" value="{{ !empty($agent->id) ? $agent->city : old('city') }}">
    @if ($errors->has('city'))
        <div class="invalid-feedback">{{ $errors->first('city') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Negara</label>
    <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" value="{{ !empty($agent->id) ? $agent->country : old('country') }}">
    @if ($errors->has('country'))
        <div class="invalid-feedback">{{ $errors->first('country') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Kode Pos</label>
    <input class="form-control @error('zip_code') is-invalid @enderror" type="text" name="zip_code" value="{{ !empty($agent->id) ? $agent->zip_code : old('zip_code') }}">
    @if ($errors->has('zip_code'))
        <div class="invalid-feedback">{{ $errors->first('zip_code') }}</div>
    @endif
</div>
<h5>Kontak</h5>
<div class="form-group">
    <label>Nama</label>
    <input class="form-control @error('contact_name') is-invalid @enderror" type="text" name="contact_name" value="{{ !empty($agent->id) ? $agent->contact_name : old('contact_name') }}">
    @if ($errors->has('contact_name'))
        <div class="invalid-feedback">{{ $errors->first('contact_name') }}</div>
    @endif
</div>
<div class="form-group">
    <label>No. Telepon</label>
    <input class="form-control @error('contact_phone_number') is-invalid @enderror" type="text" name="contact_phone_number" value="{{ !empty($agent->id) ? $agent->contact_phone_number : old('contact_phone_number') }}">
    @if ($errors->has('contact_phone_number'))
        <div class="invalid-feedback">{{ $errors->first('contact_phone_number') }}</div>
    @endif
</div>
<div class="form-group">
    <label>No. Handphone</label>
    <input class="form-control @error('contact_mobile_number') is-invalid @enderror" type="text" name="contact_mobile_number" value="{{ !empty($agent->id) ? $agent->contact_mobile_number : old('contact_mobile_number') }}">
    @if ($errors->has('contact_mobile_number'))
        <div class="invalid-feedback">{{ $errors->first('contact_mobile_number') }}</div>
    @endif
</div>
