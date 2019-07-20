@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Item</div>

    <div class="card-body">
        {{ Form::open(['url' => route('items.update', ['item' => $item->id]), 'method' => 'put']) }}
            @include('item._form_field')
            {{ Form::submit('Ubah', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
