@extends('layouts.app')
@section('title', 'Vehicle List')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Vehicle List Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('vehicles.create') }}">Add vehicle list data</a>
        </div>
    </div>

    @include('vehicle._table_list')
</div>
@endsection
