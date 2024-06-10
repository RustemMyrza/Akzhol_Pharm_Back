@extends('layouts.auth')

@section('title', config('app.name'))

@section('content')
    <div class="login-box mt-5">
        <div class="login-logo mt-5">
            <img width="40%" class="mt-5" src="{{ asset('adminlte-assets/dist/img/logo.png') }}" alt="">
        </div>

        <div class="card shadow-none">
            <div class="card-body login-card-body ">
                <p class="login-box-msg">@lang('messages.login')</p>

                <form action="{{ route('login') }}" method="post">
                    @method('POST')
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="@lang('validation.attributes.email')" name="email"
                               value="{{ old('email') }}">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="@lang('validation.attributes.password')" name="password">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" value="1">
                                <label for="remember">
                                    @lang('validation.attributes.remember')
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                <span class="fas fa-sign-in-alt"></span>
                                @lang('messages.auth')
                            </button>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection
