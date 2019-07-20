@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Membuat Item Sub Category baru</div>

    <div class="card-body">
        {{ Form::open(['url' => route('item_sub_categories.store'), 'method' => 'POST']) }}
            @include('item_sub_category._form_field')
            {{ Form::submit('Buat', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
