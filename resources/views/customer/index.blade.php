@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Pelanggan</div>

    <div class="card-body">
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Buat</a>

        @if ($customers->count() > 0)
            <table class="table">
                <thead>
                    <td>Nama</td>
                    <td>No. HP</td>
                    <td>Aksi</td>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="btn btn-light">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Belum ada pelanggan yang dibuat</p>
        @endif
    </div>
</div>
@endsection
