@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Bank</div>

    <div class="card-body">
        <a href="{{ route('bank_accounts.create') }}" class="btn btn-primary">Buat</a>

        @if ($bank_accounts->count() > 0)
            <table class="table">
                <thead>
                    <td>Nama</td>
                    <td>Bank</td>
                    <td>Akun</td>
                    <td>Aksi</td>
                </thead>
                <tbody>
                    @foreach ($bank_accounts as $bank_account)
                        <tr>
                            <td>{{ $bank_account->name }}</td>
                            <td>{{ $bank_account->bank->name }}</td>
                            <td>{{ $bank_account->account_number }}</td>
                            <td>
                                {{ Form::open(['url' => route('bank_accounts.destroy', ['bank_account' => $bank_account->id]), 'method' => 'delete']) }}
                                    {{ csrf_field() }}
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('bank_accounts.edit', ['bank_account' => $bank_account->id]) }}" class="btn btn-light">Edit</a>
                                        {{ Form::submit('Hapus', ['class' => 'btn btn-danger']) }}
                                    </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $bank_accounts->links() }}
            </div>
        @else
            <p>Belum ada akun bank yang dibuat</p>
        @endif
    </div>
</div>
@endsection
