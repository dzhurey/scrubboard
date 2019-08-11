@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Harga</div>

    <div class="card-body">
        {{ Form::open(['url' => route('prices.store'), 'method' => 'POST', 'id' => 'formPrice']) }}
            @include('price._form_field')
        {{ Form::close() }}
        <button id="buttonSubmit" class="btn btn-primary">Buat</button>
    </div>
</div>
@endsection
