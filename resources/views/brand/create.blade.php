@extends('layouts.app')
@section('title', 'Create Brand')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('item_sub_categories.index') }}">Brand Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Brand</li>
                </ol>
            </nav>
            <h1 class="mb-0">Add Brand</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-create-brand" class="c-form needs-validation" novalidate>
    @include('brand._form_field')
</form>
@endsection
