@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat user baru</div>

    <div class="card-body">
        {{ Form::open(['url' => route('people.store'), 'method' => 'POST']) }}
            @include('person._form_field')
            {{ Form::submit('Buat', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection