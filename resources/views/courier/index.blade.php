@extends('layouts.app')
@section('title', 'Courier')

@section('content')
<div id="customers-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">Courier Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('couriers.create') }}">Add Courier</a>
        </div>
    </div>

    @include('courier._table_list')
</div>
@endsection
