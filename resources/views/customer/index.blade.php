@extends('layouts.app')
@section('title', 'Customers')

@section('content')
<div id="customers-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Customer data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('customers.create') }}">Add customer data</a>
        </div>
    </div>

    @include('customer._table_list')
</div>
<span id="pageConstant" class="hidden" data-url="{{ route('customers.index') }}"></span>
@endsection
