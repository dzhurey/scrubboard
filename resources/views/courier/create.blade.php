@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Kurir baru</div>

    <div class="card-body">
        {{ Form::open(['url' => route('couriers.store'), 'method' => 'POST']) }}
            @include('courier._form_field')
            {{ Form::submit('Buat', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
