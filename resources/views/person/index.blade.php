@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User</div>

                <div class="card-body">
                    <a href="{{ route('people_create') }}" class="btn btn-primary">Buat</a>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if (!empty($people))
                        <table>
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
                                        <td>{{ App\Person::ROLES[$person->role] }}</td>
                                        <td>{{ $person->phone_number }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Belum ada user yang dibuat</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
