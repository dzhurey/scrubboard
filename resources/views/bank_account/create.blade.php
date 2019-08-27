@extends('layouts.app') 
@section('title', 'Create Bank Account')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('bank_accounts.index') }}">Bank account data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add bank account</li>
                </ol>
            </nav>
            <h1 class="mb-0">Add bank account data</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-create-bank" class="c-form needs-validation" novalidate>
    @include('bank_account._form_field')
</form>
@endsection
