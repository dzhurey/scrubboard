@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah user</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{ Form::open(['url' => route('people.update', ['person' => $person->id]), 'method' => 'put']) }}
            @include('person._form_field')
            {{ Form::submit('Ubah', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
