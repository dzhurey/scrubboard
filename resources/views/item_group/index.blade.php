@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Item Group</div>

    <div class="card-body">
        <a href="{{ route('item_groups.create') }}" class="btn btn-primary">Buat</a>

        @if ($item_groups->count() > 0 || !empty($query))
            @include('includes/index_navigation')
            <table class="table">
                <thead>
                    <td>Nama</td>
                    <td></td>
                </thead>
                <tbody>
                    @foreach ($item_groups as $item_group)
                        <tr>
                            <td>{{ $item_group->name }}</td>
                            <td>
                                {{ Form::open(['url' => route('item_groups.destroy', ['item_group' => $item_group->id]), 'method' => 'delete']) }}
                                    {{ csrf_field() }}
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('item_groups.edit', ['item_group' => $item_group->id]) }}" class="btn btn-light">Edit</a>
                                        {{ Form::submit('Hapus', ['class' => 'btn btn-danger']) }}
                                    </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $item_groups->links() }}
            </div>
        @else
            <p>Belum ada item group yang dibuat</p>
        @endif
    </div>
</div>
<span id="pageConstant" class="hidden" data-url="{{ route('item_groups.index') }}"></span>
@endsection
