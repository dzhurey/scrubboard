@extends('layouts.login') 
@section('content')
<div class="p-access">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-sm-1">
                <div class="row align-items-center vh-100">
                    <div class="col-sm-6 offset-sm-3">
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/images/logo-bebewash.png') }}" height="77">
                        </div>
                        <form class="c-form needs-validation" novalidate
                            method="POST" action="{{ route('login') }}">
                            <h2 class="c-form--title">Welcome</h2>
                            <div class="form-group">
                                <label class="c-form--label" for="validationCustom01">Email</label>
                                <input id="email" type="email" class="form-control" required autofocus
                                    name="email" value="{{ old('email') }}">
                                <div class="invalid-feedback">Email invalid.</div>
                            </div>
                            <div class="form-group">
                                <label class="c-form--label" for="validationCustom02">Password</label>
                                <input id="password" type="password" class="form-control"
                                    name="password" required autocomplete="current-password">
                                <div class="invalid-feedback">Password invalid.</div>
                            </div>
                            <hr class="my-4">
                            <div class="text-right">
                                <button class="btn btn-primary btn-block" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
