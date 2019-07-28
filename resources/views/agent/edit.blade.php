@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Konsumen</div>

    <div class="card-body">
        {{ Form::open(['url' => route('agents.update', ['agent' => $agent->id]), 'method' => 'put']) }}
            @include('agent._form_field')
            {{ Form::submit('Ubah', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
