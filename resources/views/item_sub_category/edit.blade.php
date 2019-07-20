@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mengubah Akun Item Sub Category</div>

    <div class="card-body">
        {{ Form::open(['url' => route('item_sub_categories.update', ['item_sub_category' => $item_sub_category->id]), 'method' => 'put']) }}
            @include('item_sub_category._form_field')
            {{ Form::submit('Ubah', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
