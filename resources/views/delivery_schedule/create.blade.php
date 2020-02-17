@extends('layouts.app')
@section('title', 'Create Delivery Schedule')

@section('content')
<div id="delivery-schedule-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('delivery_schedules.index') }}">Delivery Schedule Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Delivery Schedule</li>
                </ol>
            </nav>
            <h1 class="mb-0">Add Delivery Schedule</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-create-delivery" class="c-form is-fluid needs-validation" novalidate>
    @include('delivery_schedule._form_field')
</form>
@include('delivery_schedule._modal_sales_invoice')
@endsection
