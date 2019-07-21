@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Kendaraan</div>

    <div class="card-body">
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Buat</a>

        @if ($vehicles->count() > 0 || !empty($query))
            @include('includes/index_navigation')
            <table class="table">
                <thead>
                    <td>Plat Nomor</td>
                    <td></td>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->number }}</td>
                            <td>
                                {{ Form::open(['url' => route('vehicles.destroy', ['vehicle' => $vehicle->id]), 'method' => 'delete']) }}
                                    {{ csrf_field() }}
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('vehicles.edit', ['vehicle' => $vehicle->id]) }}" class="btn btn-light">Edit</a>
                                        {{ Form::submit('Hapus', ['class' => 'btn btn-danger']) }}
                                    </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $vehicles->links() }}
            </div>
        @else
            <p>Belum ada kendaraan yang dibuat</p>
        @endif
    </div>
</div>
<span id="pageConstant" class="hidden" data-url="{{ route('vehicles.index') }}"></span>
@endsection
