@extends('layouts.app')
@section('title', 'Promo Data')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">Promo Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('promos.create') }}">Add Promo</a>
        </div>
    </div>

    @include('promo._table_list')
</div>
@endsection
