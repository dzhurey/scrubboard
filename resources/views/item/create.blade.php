@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Item baru</div>

    <div class="card-body">
        {{ Form::open(['url' => route('items.store'), 'method' => 'POST']) }}
            @include('item._form_field')
            {{ Form::submit('Buat', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
