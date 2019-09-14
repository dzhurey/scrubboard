@extends('layouts.app')
@section('title', 'Edit Delivery Schedule')

@section('content')
<div id="Screen Shot 2019-08-26 at 17.48.51-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('courier.delivery_schedules.index') }}">Delivery Schedule</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit Delivery Schedule</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-courier-delivery-schedule" class="c-form is-fluid needs-validation" enctype="multipart/form-data" novalidate>
    @include('courier_delivery_schedule._form_field')
</form>
@endsection
