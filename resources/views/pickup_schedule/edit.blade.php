@extends('layouts.app')
@section('title', 'Edit Pickup Schedule')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pickup_schedules.index') }}">Pickup Schedule data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit pickup Schedule</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit pickup Schedule data</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-pickup" class="c-form needs-validation" novalidate>
    @include('pickup_schedule._form_field')
</form>
@endsection
