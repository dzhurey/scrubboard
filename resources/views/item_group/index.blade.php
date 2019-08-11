@extends('layouts.app')
@section('title', 'Item Category')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0">Item Category Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('item_groups.create') }}">Add item category data</a>
        </div>
    </div>

    @include('item_group._table_list')
</div>
@endsection
