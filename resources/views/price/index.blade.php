@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Harga</div>

    <div class="card-body">
        <a href="{{ route('prices.create') }}" class="btn btn-primary">Buat</a>

        @if ($prices->count() > 0 || !empty($query))
            @include('includes/index_navigation')
            <table class="table">
                <thead>
                    <td>Harga</td>
                    <td></td>
                </thead>
                <tbody>
                    @foreach ($prices as $price)
                        <tr>
                            <td>{{ $price->name }}</td>
                            <td>
                                {{ Form::open(['url' => route('prices.destroy', ['price' => $price->id]), 'method' => 'delete']) }}
                                    {{ csrf_field() }}
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('prices.edit', ['price' => $price->id]) }}" class="btn btn-light">Edit</a>
                                        {{ Form::submit('Hapus', ['class' => 'btn btn-danger']) }}
                                    </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $prices->links() }}
            </div>
        @else
            <p>Belum ada harga yang dibuat</p>
        @endif
    </div>
</div>
<span id="pageConstant" class="hidden" data-url="{{ route('prices.index') }}"></span>
@endsection
