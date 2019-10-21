@extends('layouts.app')
@section('title', 'Client')

@section('content')
<div id="customers-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">Client Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('customers.create') }}">Add Client</a>
        </div>
    </div>

    @include('customer._table_list')
</div>
@endsection
