@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Agen baru</div>

    <div class="card-body">
        {{ Form::open(['url' => route('agents.store'), 'method' => 'POST']) }}
            @include('agent._form_field')
            {{ Form::submit('Buat', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
