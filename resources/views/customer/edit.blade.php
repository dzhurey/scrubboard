@extends('layouts.app') 
@section('title', 'Edit Customer')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('customers.index') }}">Customer data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit customer</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit customer data</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-customer" class="c-form needs-validation" novalidate>
    @include('customer._form_field')
</form>
@endsection
