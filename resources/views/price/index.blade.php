@extends('layouts.app')
@section('title', 'Price List')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">Price List Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('prices.create') }}">Add Price List</a>
        </div>
    </div>

    @include('price._table_list')
</div>
@endsection
