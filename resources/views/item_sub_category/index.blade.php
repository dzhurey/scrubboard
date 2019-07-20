@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Item Sub Category</div>

    <div class="card-body">
        <a href="{{ route('item_sub_categories.create') }}" class="btn btn-primary">Buat</a>

        @if ($item_sub_categories->count() > 0)
            <table class="table">
                <thead>
                    <td>Nama</td>
                    <td>Item Group</td>
                    <td>Aksi</td>
                </thead>
                <tbody>
                    @foreach ($item_sub_categories as $item_sub_category)
                        <tr>
                            <td>{{ $item_sub_category->name }}</td>
                            <td>{{ $item_sub_category->itemGroup->name }}</td>
                            <td>
                                {{ Form::open(['url' => route('item_sub_categories.destroy', ['item_sub_category' => $item_sub_category->id]), 'method' => 'delete']) }}
                                    {{ csrf_field() }}
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('item_sub_categories.edit', ['item_sub_category' => $item_sub_category->id]) }}" class="btn btn-light">Edit</a>
                                        {{ Form::submit('Hapus', ['class' => 'btn btn-danger']) }}
                                    </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Belum ada akun item sub category yang dibuat</p>
        @endif
    </div>
</div>
<span id="pageConstant" class="hidden" data-url="{{ route('item_sub_categories.index') }}"></span>
@endsection
