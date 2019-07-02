@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User</div>

                <div class="card-body">
                    <a href="{{ route('user_create') }}" class="btn btn-primary">Buat</a>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (empty($people))
                        @foreach ($people as $person)
                            <p>This is user {{ $person->name }}</p>
                        @endforeach
                    @else
                        <p>Belum ada user yang dibuat</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
