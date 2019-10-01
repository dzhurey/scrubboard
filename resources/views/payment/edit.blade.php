@extends('layouts.app')
@section('title', 'Edit Payment')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('payments.index') }}">Payment Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Payment</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit Payment</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-sales-invoice" class="c-form is-fluid needs-validation" novalidate>
    @include('payment._form_field')
</form>
@include('payment._modal_sales_invoices')
@endsection
