@extends('layouts.app')
@section('title', 'Courier Schedule')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Courier Schedule Data</h1>
        </div>
    </div>

    @include('courier_schedule._table_list')
</div>
@endsection
