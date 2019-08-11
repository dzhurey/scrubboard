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
                            @csrf
                            <h2 class="c-form--title">
                                {{ __('Welcome') }}
                            </h2>
                            <div class="form-group">
                                <label class="c-form--label" for="email">
                                    {{ __('Email') }}
                                </label>
                                <input id="email" type="email" class="form-control" required autofocus
                                    name="email" value="{{ old('email') }}">
                                <div class="invalid-feedback">
                                    {{ __('Email invalid.') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="c-form--label" for="password">
                                    {{ __('Password') }}
                                </label>
                                <input id="password" type="password" class="form-control"
                                    name="password" required autocomplete="current-password">
                                <div class="invalid-feedback">
                                    {{ __('Password invalid.') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="text-right">
                                <button class="btn btn-primary btn-block" type="submit">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection