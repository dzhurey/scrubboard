@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Item Group baru</div>

    <div class="card-body">
        {{ Form::open(['url' => route('item_groups.store'), 'method' => 'POST']) }}
            @include('item_group._form_field')
            {{ Form::submit('Buat', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
