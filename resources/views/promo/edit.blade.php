@extends('layouts.app') 
@section('title', 'Edit Promo')

@section('content')
<div id="promos-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('promos.index') }}">Promos Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Promo</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit Promo</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-promo" class="c-form needs-validation" novalidate>
    @include('promo._form_field')
</form>
@endsection
