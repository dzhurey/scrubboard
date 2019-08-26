@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Order</div>

    <div class="card-body">
        {{ Form::open(['url' => route('sales_orders.store'), 'method' => 'POST', 'id' => 'formSalesOrder']) }}
            @include('sales_invoice._form_field')
        {{ Form::close() }}
        <button id="buttonSubmit" class="btn btn-primary">Buat</button>
    </div>
</div>
@endsection
