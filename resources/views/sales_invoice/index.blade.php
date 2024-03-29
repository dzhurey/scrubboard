@extends('layouts.app')
@section('title', 'Sales Invoices')

@section('content')
<div id="sales-invoice-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Sales Invoice Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('sales_invoices.create') }}">Add Sales Invoice</a>
        </div>
    </div>

    @include('sales_invoice._table_list')
</div>
@endsection
