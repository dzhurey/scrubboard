@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Akun Bank baru</div>

    <div class="card-body">
        {{ Form::open(['url' => route('bank_accounts.store'), 'method' => 'POST']) }}
            @include('bank_account._form_field')
            {{ Form::submit('Buat', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
