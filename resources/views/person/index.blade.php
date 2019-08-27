@extends('layouts.app')
@section('title', 'User List')

@section('content')
<div id="sub-category-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">User Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('people.create') }}">Add user data</a>
        </div>
    </div>

    @include('person._table_list')
</div>
@endsection
