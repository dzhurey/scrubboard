@extends('layouts.app')
@section('title', 'POS Data')

@section('content')
<div id="customers-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
            <h1 class="mb-0 mt-1">POS Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('agents.create') }}">Add POS</a>
        </div>
    </div>

    @include('agent._table_list')
</div>
@endsection
