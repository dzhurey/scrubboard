@extends('layouts.app')
@section('title', 'Pickup Schedule')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Pickup Schedule Data</h1>
        </div>
    </div>

    @include('courier_pickup_schedule._table_list')
</div>
@endsection
