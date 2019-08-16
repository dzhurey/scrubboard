@extends('layouts.app')
@section('title', 'Edit Sub Category')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('customers.index') }}">Item sub categories data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit item sub category</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit item sub category data</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-sub-category" class="c-form needs-validation" novalidate>
    @include('item_sub_category._form_field')
</form>
@endsection
