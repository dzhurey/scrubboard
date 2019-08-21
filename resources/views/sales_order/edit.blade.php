@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Order</div>

    <div class="card-body">
        {{ Form::open(['url' => route('sales_orders.update', ['sales_order' => $sales_order->id]), 'method' => 'put', 'id' => 'formSalesOrder']) }}
            @include('sales_order._form_field')
        {{ Form::close() }}
        <button id="buttonSubmit" class="btn btn-primary">Update</button>
    </div>
</div>
@endsection

@section('script')

@stop