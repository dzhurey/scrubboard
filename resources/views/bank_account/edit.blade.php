@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Akun Bank</div>

    <div class="card-body">
        {{ Form::open(['url' => route('bank_accounts.update', ['bank_account' => $bank_account->id]), 'method' => 'put']) }}
            @include('bank_account._form_field')
            {{ Form::submit('Ubah', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
