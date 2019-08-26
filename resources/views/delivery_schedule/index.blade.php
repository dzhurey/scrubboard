@extends('layouts.app')
@section('title', 'Delivery Schedule')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Delivery Schedule</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('delivery_schedules.create') }}">Add delivery schedule</a>
        </div>
    </div>

    @include('delivery_schedule._table_list')
</div>
@endsection
