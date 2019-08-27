@extends('layouts.app')
@section('title', 'Sales Order')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Sales Order</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('sales_orders.create') }}">Add Sales Order</a>
        </div>
    </div>

    @include('sales_order._table_list')
</div>
@endsection
