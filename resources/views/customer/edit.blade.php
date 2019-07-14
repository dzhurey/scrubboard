@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Konsumen</div>

    <div class="card-body">
        {{ Form::open(['url' => route('customers.update', ['customer' => $customer->id]), 'method' => 'put']) }}
            @include('customer._form_field')
            {{ Form::submit('Ubah', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
