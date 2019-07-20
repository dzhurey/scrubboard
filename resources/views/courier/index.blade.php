@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Kurir</div>

    <div class="card-body">
        <a href="{{ route('couriers.create') }}" class="btn btn-primary">Buat</a>

        @if ($couriers->count() > 0 || !empty($query))
            @include('includes/index_navigation')
            <table class="table">
                <thead>
                    <td>Nama</td>
                    <td>No. HP</td>
                    <td></td>
                </thead>
                <tbody>
                    @foreach ($couriers as $courier)
                        <tr>
                            <td>{{ $courier->name }}</td>
                            <td>{{ $courier->phone_number }}</td>
                            <td>
                                {{ Form::open(['url' => route('couriers.destroy', ['courier' => $courier->id]), 'method' => 'delete']) }}
                                    {{ csrf_field() }}
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('couriers.edit', ['courier' => $courier->id]) }}" class="btn btn-light">Edit</a>
                                        {{ Form::submit('Hapus', ['class' => 'btn btn-danger']) }}
                                    </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $couriers->links() }}
            </div>
        @else
            <p>Belum ada kurir yang dibuat</p>
        @endif
    </div>
</div>
<span id="pageConstant" class="hidden" data-url="{{ route('couriers.index') }}"></span>
@endsection
