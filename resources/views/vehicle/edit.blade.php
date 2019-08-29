@extends('layouts.app')
@section('title', 'Edit Vehicle')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('vehicles.index') }}">Vehicle Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Vehicle</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit Vehicle</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-vehicle" class="c-form needs-validation" novalidate>
    @include('vehicle._form_field')
</form>
@endsection
