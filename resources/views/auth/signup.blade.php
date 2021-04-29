@extends('layouts.app')

@section('title', 'SignUp Form')

@section('content')
<div class="login-area login-bg">
    <div class="container">
        <div class="login-box ptb--100">
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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="login-form-head">
                    <h4>Registrasi Akun</h4>
                    <p>Buat Akun Anda</p>
                </div>
                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name"  name="name" value="{{ old('name') }}" required autocomplete="name">
                        <i class="ti-pencil"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="form-gp">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required autocomplete="username">
                        <i class="ti-user"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="form-gp">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password">
                        <i class="ti-lock"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="form-gp">
                        <label for="password-confirm">Konfirmasi Password</label>
                        <input type="password" id="password-confirm" name="password_confirmation" required autocomplete="new-password">
                        <i class="ti-lock"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit"> {{ __('Daftar') }} <i class="ti-arrow-right"></i></button>                               
                    </div>
                    <div class="form-footer text-center mt-5">
                        <p class="text-muted">Sudah Punya Akun? <a href="{{ route('login') }}">Login</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection