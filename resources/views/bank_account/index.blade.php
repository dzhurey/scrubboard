@extends('layouts.app')
@section('title', 'Bank Account')

@section('content')
<div id="customers-list">
    <div class="c-title row no-gutters">
        <div class="col-sm-6">
          <h1 class="mb-0 mt-1">Bank Account Data</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a class="btn btn-primary" href="{{ route('bank_accounts.create') }}">Add Bank Account</a>
        </div>
    </div>

    @include('bank_account._table_list')
</div>
@endsection
