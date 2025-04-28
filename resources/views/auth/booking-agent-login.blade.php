@extends('adminlte::master')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('title', 'Booking Agent Login')

@section('classes_body', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>Q</b>Med</a>
        </div>
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h4><b>Booking Agent</b> Login</h4>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in with your booking agent email</p>

                <form action="{{ route('booking-agent.login') }}" method="post">
                    @csrf

                    <!-- Email field -->
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                            placeholder="Booking Agent Email" value="{{ old('email') }}" autofocus>
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

                    <!-- Password field -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                            placeholder="Password">
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

                    <!-- Login field -->
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-4 mb-1 text-center">
                    <p class="mb-0">
                        <a href="{{ route('password.request') }}">I forgot my password</a>
                    </p>
                    <p class="mt-3 mb-0">
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-user mr-1"></i> Standard Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop 