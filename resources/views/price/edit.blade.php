@extends('layouts.app')
@section('title', 'Edit Price List')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('prices.index') }}">Price List Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Price List</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit Price List</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-price" class="c-form needs-validation" novalidate>
    @include('price._form_field')
</form>
@endsection
