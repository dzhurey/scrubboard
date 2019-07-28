@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Agen</div>

    <div class="card-body">
        <a href="{{ route('agents.create') }}" class="btn btn-primary">Buat</a>

        @if ($agents->count() > 0 || !empty($query))
            @include('includes/index_navigation')
            <table class="table">
                <thead>
                    <td>Nama</td>
                    <td>No. HP</td>
                    <td>Aksi</td>
                </thead>
                <tbody>
                    @foreach ($agents as $agent)
                        <tr>
                            <td>{{ $agent->name }}</td>
                            <td>{{ $agent->phone_number }}</td>
                            <td>
                                {{ Form::open(['url' => route('agents.destroy', ['agent' => $agent->id]), 'method' => 'delete']) }}
                                    {{ csrf_field() }}
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('agents.edit', ['agent' => $agent->id]) }}" class="btn btn-light">Edit</a>
                                        {{ Form::submit('Hapus', ['class' => 'btn btn-danger']) }}
                                    </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $agents->links() }}
            </div>
        @else
            <p>Belum ada agen yang dibuat</p>
        @endif
    </div>
</div>
<span id="pageConstant" class="hidden" data-url="{{ route('agents.index') }}"></span>
@endsection
