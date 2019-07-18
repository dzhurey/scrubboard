{{ csrf_field() }}
<div class="form-group">
    <label>Nama</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ !empty($bank_account->id) ? $bank_account->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>
<div class="form-group">
    <label>Bank</label>
    {{ Form::select('bank_id', $banks, !empty($bank_account->id) ? $bank_account->bank_id : old('bank_id'), ['class' => 'form-control '.($errors->has('bank_id') ? 'is-invalid' : '') ]) }}
    @if ($errors->has('bank_id'))
        <div class="invalid-feedback">{{ $errors->first('bank_id') }}</div>
    @endif
</div>
<div class="form-group">
    <label>No. Akun</label>
    <input class="form-control @error('account_number') is-invalid @enderror" type="text" name="account_number" value="{{ !empty($bank_account->id) ? $bank_account->account_number : old('account_number') }}">
    @if ($errors->has('account_number'))
        <div class="invalid-feedback">{{ $errors->first('account_number') }}</div>
    @endif
</div>
