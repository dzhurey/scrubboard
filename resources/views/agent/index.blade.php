@extends('layouts.app')
@section('title', 'Outlet Data')

@section('content')
<div id="customers-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <h1 class="mb-0 mt-1">Outlet Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('agents.create') }}">Add Outlet</a>
        </div>
    </div>

    @include('agent._table_list')
</div>
@endsection
