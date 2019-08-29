@extends('layouts.app')
@section('title', 'Payments')

@section('content')
<div id="sales-invoice-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Payment Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('payments.create') }}">Add Payment</a>
        </div>
    </div>

    @include('payment._table_list')
</div>
@endsection
