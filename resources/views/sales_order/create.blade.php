@extends('layouts.app')
@section('title', 'Create Sales Order')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('sales_orders.index') }}">Sales order data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add sales order data</li>
                </ol>
            </nav>
            <h1 class="mb-0">Add sales order data</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-create-sales-order" class="c-form is-fluid needs-validation" novalidate>
    @include('sales_order._form_field')
</form>
@endsection
