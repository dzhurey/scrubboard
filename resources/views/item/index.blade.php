@extends('layouts.app')
@section('title', 'Item Data')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">Item Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('items.create') }}">Add Item</a>
        </div>
    </div>

    @include('item._table_list')
</div>
@endsection
