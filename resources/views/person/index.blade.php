@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">User</div>

    <div class="card-body">
        <a href="{{ route('people.create') }}" class="btn btn-primary">Buat</a>

        @if ($people->count() > 0)
            <table class="table">
                <thead>
                    <td>Nama</td>
                    <td>Role</td>
                    <td>No. HP</td>
                    <td>Aksi</td>
                </thead>
                <tbody>
                    @foreach ($people as $person)
                        <tr>
                            <td>{{ $person->name }}</td>
                            <td>{{ App\User::ROLES[$person->user->role] }}</td>
                            <td>{{ $person->phone_number }}</td>
                            <td>
                                {{ Form::open(['url' => route('people.destroy', ['person' => $person->id]), 'method' => 'delete']) }}
                                    {{ csrf_field() }}
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('people.edit', ['person' => $person->id]) }}" class="btn btn-light">Edit</a>
                                        {{ Form::submit('Hapus', ['class' => 'btn btn-danger']) }}
                                    </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Belum ada user yang dibuat</p>
        @endif
    </div>
</div>
@endsection
