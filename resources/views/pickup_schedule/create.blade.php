@extends('layouts.app')
@section('title', 'Create Pickup Schedule')

@section('content')
<div id="pickup-schedule-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pickup_schedules.index') }}">Pickup Schedule Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Pickup Schedule</li>
                </ol>
            </nav>
            <h1 class="mb-0">Add Pickup Schedule</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-create-pickup" class="c-form needs-validation" novalidate>
    @include('pickup_schedule._form_field')
</form>
@include('pickup_schedule._modal_sales_order')
@endsection
