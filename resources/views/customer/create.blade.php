@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Pelanggan baru</div>

    <div class="card-body">
        {{ Form::open(['url' => route('customers.store'), 'method' => 'POST']) }}
            @include('customer._form_field')
            {{ Form::submit('Buat', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
