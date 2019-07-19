@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Kurir</div>

    <div class="card-body">
        {{ Form::open(['url' => route('couriers.update', ['courier' => $courier->id]), 'method' => 'put']) }}
            @include('courier._form_field')
            {{ Form::submit('Ubah', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
