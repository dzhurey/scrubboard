@extends('layouts.app')
@section('title', 'Edit Category')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('item_groups.index') }}">Item Category Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Item Category</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit Item Category</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-category" class="c-form needs-validation" novalidate>
    @include('item_group._form_field')
</form>
@endsection
