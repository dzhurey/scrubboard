@extends('layouts.app') 
@section('title', 'Create POS')

@section('content')
<div id="customers-form">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb c-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('agents.index') }}">POS Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add POS</li>
                </ol>
            </nav>
            <h1 class="mb-0">Add POS</h1>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<form id="form-create-agent" class="c-form needs-validation" novalidate>
    @include('agent._form_field')
</form>
@endsection
