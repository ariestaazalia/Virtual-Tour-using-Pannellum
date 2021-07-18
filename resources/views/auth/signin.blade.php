@extends('auth.layouts.main')

@section('title', 'Login Form')

@section('content')
<div class="login-area login-bg">
    <div class="container">
        <div class="login-box ptb--100">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="login-form-head">
                    <h4>Login</h4>
                    <p>Halo, Login untuk Kelola Virtual Tour Anda</p>
                </div>

                <div class="login-form-body">

                @if ($message = Session::get('success'))
                    <div class="alert-dismiss">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span class="fa fa-times"></span>
                            </button>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-dismiss">
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $errors->first() }}</strong>
                        </div>
                    </div>
                @endif
                
                    <div class="form-gp">
                        <label for="username">Username</label>
                        <input id="username" type="username" 
                            name="username" value="{{ old('username') }}" required>
                        <i class="ti-user"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="form-gp">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required>
                        <i class="ti-lock"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit">{{ __('Masuk') }} <i class="ti-arrow-right"></i></button>
                    </div>
                    <div class="form-footer text-center mt-5">
                        <p class="text-muted">Tidak Punya Akun? <a href="{{ route('register') }}">Registrasi</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection