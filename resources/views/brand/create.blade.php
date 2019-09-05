@extends('layouts.app')
@section('title', 'Create Sub Category')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('item_sub_categories.index') }}">Item Sub Category Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Item Sub Category</li>
                </ol>
            </nav>
            <h1 class="mb-0">Add Item Sub Category</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-create-sub-category" class="c-form needs-validation" novalidate>
    @include('item_sub_category._form_field')
</form>
@endsection
