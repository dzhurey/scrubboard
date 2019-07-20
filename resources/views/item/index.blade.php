@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Item</div>

    <div class="card-body">
        <a href="{{ route('items.create') }}" class="btn btn-primary">Buat</a>

        @if ($items->count() > 0)
            <table class="table">
                <thead>
                    <td>Deskripsi</td>
                    <td>Group</td>
                    <td>Sub Category</td>
                    <td>Harga</td>
                    <td></td>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->itemSubCategory->itemGroup->name }}</td>
                            <td>{{ $item->itemSubCategory->name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>
                                {{ Form::open(['url' => route('items.destroy', ['item' => $item->id]), 'method' => 'delete']) }}
                                    {{ csrf_field() }}
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('items.edit', ['item' => $item->id]) }}" class="btn btn-light">Edit</a>
                                        {{ Form::submit('Hapus', ['class' => 'btn btn-danger']) }}
                                    </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Belum ada item yang dibuat</p>
        @endif
    </div>
</div>
@endsection
