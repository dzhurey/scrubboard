@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('people.index') }}">User data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit user data</li>
                </ol>
            </nav>
            <h1 class="mb-0">Edit user data</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-edit-user" class="c-form needs-validation" novalidate>
    @include('person._form_field')
</form>
@endsection
