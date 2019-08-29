@extends('layouts.app')
@section('title', 'Vehicle')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">Vehicle Data</h4>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('vehicles.create') }}">Add Vehicle Data</a>
        </div>
    </div>

    @include('vehicle._table_list')
</div>
@endsection
