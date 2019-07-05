@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Membuat user baru</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ Form::open(['url' => 'people']) }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Nama</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email') }}">
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
                            <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" value="{{ old('phone_number') }}">
                            @if ($errors->has('phone_number'))
                                <div class="invalid-feedback">{{ $errors->first('phone_number') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input class="form-control @error('birth_date') is-invalid @enderror" type="date" name="birth_date" value="{{ old('birth_date') }}">
                            @if ($errors->has('birth_date'))
                                <div class="invalid-feedback">{{ $errors->first('birth_date') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            {{ Form::select('gender', App\Person::GENDERS, old('gender'), ['class' => 'form-control'.($errors->has('gender') ? 'is-invalid' : '') ]) }}
                            @if ($errors->has('gender'))
                                <div class="invalid-feedback">{{ $errors->first('gender') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Agama</label>
                            {{ Form::select('religion', App\Person::RELIGIONS, old('religion'), ['class' => 'form-control'.($errors->has('religion') ? 'is-invalid' : '') ]) }}
                            @if ($errors->has('religion'))
                                <div class="invalid-feedback">{{ $errors->first('religion') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address') }}</textarea>
                            @if ($errors->has('address'))
                                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <input class="form-control @error('district') is-invalid @enderror" type="text" name="district" value="{{ old('district') }}">
                            @if ($errors->has('district'))
                                <div class="invalid-feedback">{{ $errors->first('district') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Kota</label>
                            <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" value="{{ old('city') }}">
                            @if ($errors->has('city'))
                                <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Negara</label>
                            <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" value="{{ old('country') }}">
                            @if ($errors->has('country'))
                                <div class="invalid-feedback">{{ $errors->first('country') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Kode Pos</label>
                            <input class="form-control @error('zipcode') is-invalid @enderror" type="text" name="zipcode" value="{{ old('zipcode') }}">
                            @if ($errors->has('zipcode'))
                                <div class="invalid-feedback">{{ $errors->first('zipcode') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            {{ Form::select('role', App\Person::ROLES, old('role'), ['class' => 'form-control'.($errors->has('role') ? 'is-invalid' : '') ]) }}
                            @if ($errors->has('role'))
                                <div class="invalid-feedback">{{ $errors->first('role') }}</div>
                            @endif
                        </div>
                        {{ Form::submit('Simpan', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
