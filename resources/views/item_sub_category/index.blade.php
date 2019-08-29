@extends('layouts.app')
@section('title', 'Sub Category')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">Item Sub Category Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('item_sub_categories.create') }}">Add Item Sub Category</a>
        </div>
    </div>

    @include('item_sub_category._table_list')
</div>
@endsection
