@extends('layouts.app')
@section('title', 'Create Vehicle')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('vehicles.index') }}">Vehicle data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Vehicle data</li>
                </ol>
            </nav>
            <h1 class="mb-0">Add vehicle data</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-create-vehicle" class="c-form needs-validation" novalidate>
    @include('vehicle._form_field')
</form>
@endsection
