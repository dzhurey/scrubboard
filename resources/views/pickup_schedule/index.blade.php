@extends('layouts.app')
@section('title', 'Pick up Schedule')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Pick up Schedule</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('pickup_schedules.create') }}">Add pickup schedule</a>
        </div>
    </div>

    @include('pickup_schedule._table_list')
</div>
@endsection
