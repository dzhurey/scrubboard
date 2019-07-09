@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Kendaraan</div>

    <div class="card-body">
        <a href="{{ route('vehicle.create') }}" class="btn btn-primary">Buat</a>

        @if ($vehicles->count() > 0)
            <table class="table">
                <thead>
                    <td>Plat Nomor</td>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->number }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Belum ada kendaraan yang dibuat</p>
        @endif
    </div>
</div>
@endsection
