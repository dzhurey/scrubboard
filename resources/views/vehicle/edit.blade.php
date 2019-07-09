@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Kendaraan</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{ Form::open(['url' => route('vehicles.update', ['vehicle' => $vehicle->id]), 'method' => 'put']) }}
            @include('vehicle._form_field')
            {{ Form::submit('Ubah', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
