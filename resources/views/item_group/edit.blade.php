@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Item Group</div>

    <div class="card-body">
        {{ Form::open(['url' => route('item_groups.update', ['item_group' => $item_group->id]), 'method' => 'put']) }}
            @include('item_group._form_field')
            {{ Form::submit('Ubah', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
