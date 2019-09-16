@extends('layouts.app')
@section('title', 'Edit Courier')

@section('content')
<div id="delivery-schedule-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('delivery_schedules.index') }}">Courier Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Courier</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit Courier</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-courier" class="c-form needs-validation" novalidate>
    @include('courier._form_field')
</form>
@endsection