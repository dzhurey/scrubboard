@extends('layouts.app')
@section('title', 'Edit Sales Order')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('sales_orders.index') }}">Sales order data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit sales order data</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit sales order data</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-sales-order" class="c-form needs-validation" novalidate>
    @include('sales_order._form_field')
</form>
@endsection