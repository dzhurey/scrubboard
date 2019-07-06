{{ csrf_field() }}
<div class="form-group">
    <label>Nama</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ !empty($person->id) ? $person->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Email</label>
    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ !empty($person->id) ? $person->email : old('email') }}">
    @if ($errors->has('email'))
        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Password</label>
    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{ old('password') }}">
    @if ($errors->has('password'))
        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Konfirmasi Password</label>
    <input class="form-control @error('confirm_password') is-invalid @enderror" type="password" name="confirm_password" value="{{ old('password') }}">
    @if ($errors->has('confirm_password'))
        <div class="invalid-feedback">{{ $errors->first('confirm_password') }}</div>
    @endif
</div>
<div class="form-group">
    <label>No. Handphone</label>
    <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" value="{{ !empty($person->id) ? $person->phone_number : old('phone_number') }}">
    @if ($errors->has('phone_number'))
        <div class="invalid-feedback">{{ $errors->first('phone_number') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Tanggal Lahir</label>
    <input class="form-control @error('birth_date') is-invalid @enderror" type="date" name="birth_date" value="{{ !empty($person->id) ? $person->birth_date : old('birth_date') }}">
    @if ($errors->has('birth_date'))
        <div class="invalid-feedback">{{ $errors->first('birth_date') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Gender</label>
    {{ Form::select('gender', App\Person::GENDERS, !empty($person->id) ? $person->gender : old('gender'), ['class' => 'form-control'.($errors->has('gender') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('gender'))
        <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Agama</label>
    {{ Form::select('religion', App\Person::RELIGIONS, !empty($person->id) ? $person->religion : old('religion'), ['class' => 'form-control'.($errors->has('religion') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('religion'))
        <div class="invalid-feedback">{{ $errors->first('religion') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Alamat</label>
    <textarea class="form-control @error('address') is-invalid @enderror" name="address">{{ !empty($person->id) ? $person->address : old('address') }}</textarea>
    @if ($errors->has('address'))
        <div class="invalid-feedback">{{ $errors->first('address') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Kecamatan</label>
    <input class="form-control @error('district') is-invalid @enderror" type="text" name="district" value="{{ !empty($person->id) ? $person->district : old('district') }}">
    @if ($errors->has('district'))
        <div class="invalid-feedback">{{ $errors->first('district') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Kota</label>
    <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" value="{{ !empty($person->id) ? $person->city : old('city') }}">
    @if ($errors->has('city'))
        <div class="invalid-feedback">{{ $errors->first('city') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Negara</label>
    <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" value="{{ !empty($person->id) ? $person->country : old('country') }}">
    @if ($errors->has('country'))
        <div class="invalid-feedback">{{ $errors->first('country') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Kode Pos</label>
    <input class="form-control @error('zip_code') is-invalid @enderror" type="text" name="zip_code" value="{{ !empty($person->id) ? $person->zip_code : old('zip_code') }}">
    @if ($errors->has('zip_code'))
        <div class="invalid-feedback">{{ $errors->first('zip_code') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Role</label>
    {{ Form::select('role', App\Person::ROLES, !empty($person->id) ? $person->role : old('role'), ['class' => 'form-control'.($errors->has('role') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('role'))
        <div class="invalid-feedback">{{ $errors->first('role') }}</div>
    @endif
</div>