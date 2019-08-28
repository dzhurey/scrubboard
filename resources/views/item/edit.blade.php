@extends('layouts.app') 
@section('title', 'Edit Item')

@section('content')
<div id="items-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('items.index') }}">Items data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit item data</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit items data</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-item" class="c-form needs-validation" novalidate>
    @include('item._form_field')
</form>
@endsection
