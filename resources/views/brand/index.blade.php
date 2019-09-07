@extends('layouts.app')
@section('title', 'Brand')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">Brands Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('brands.create') }}">Add Brand</a>
        </div>
    </div>

    @include('brand._table_list')
</div>
@endsection
