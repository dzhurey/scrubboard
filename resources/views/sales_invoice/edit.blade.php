@extends('layouts.app')
@section('title', 'Edit Sales Invoice')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('sales_invoices.index') }}">Sales Invoice Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Sales Invoice</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit Sales Invoice</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-sales-invoice" class="c-form is-fluid needs-validation" novalidate>
    @include('sales_invoice._form_field')
</form>
@endsection
