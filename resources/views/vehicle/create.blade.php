@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Kendaraan baru</div>

    <div class="card-body">
        {{ Form::open(['url' => route('vehicles.store'), 'method' => 'POST']) }}
            @include('vehicle._form_field')
            {{ Form::submit('Buat', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
