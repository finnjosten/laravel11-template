@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Login || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main class="login-page page--form">
    <div class="content">
        <a href="{{ route('home') }}">
            <div class="image-block">
                <img src="/images/logos/logo.svg"/>
            </div>
        </a>
        <div class="form">
            @if (!empty(request()->query('return')))
                <form method="post" action="{{ route('login.post', ["return" => request()->query('return')]) }}">
            @else
                <form method="post" action="{{ route('login.post') }}">
            @endif
                @csrf
                <h2>Login</h2>
                <div class="link">
                    <hr>
                    <h5>
                        LOGIN WITH EMAIL
                    </h5>
                    <hr>
                </div>
                <div>
                    <h4>Email</h4>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                </div>
                <div class="passBox">
                    <h4>Password @if(env('SETTING_CAN_RESET_PASSWORD')) {{-- <a href="{{ route('forgot-password') }}">forgot password</a> --}} @endif</h4>
                    <input type="password" name="password" class="password" required>
                    <a class="showPass" onclick="showPass()"><i class="showPassBtn da-icon da-icon--eye"></i></a>
                </div>
                <div class="link">
                    <button class="btn btn--primary" type="submit" name="login">Login</button>
                </div>
                @if(env('SETTING_CAN_REGISTER'))
                    <div class="link">
                        <hr>
                        <h5>
                            <a href="{{ route('register') }}">REGISTER</a>
                        </h5>
                        <hr>
                    </div>
                @endif
            </form>
            <script>
                function showPass() {
                    const passwords = document.querySelectorAll(".passBox");
                    passwords.forEach(password => {
                        var myPass = password.querySelector(".password");
                        var showPass = password.querySelector(".showPass");
                        var showPassBtn = password.querySelector(".showPassBtn");
                        if (myPass.type === "password") {
                            myPass.type = "text";
                            showPassBtn.classList.remove("da-icon--eye");
                            showPassBtn.classList.add("da-icon--eye-slash");
                        } else {
                            myPass.type = "password";
                            showPassBtn.classList.add("da-icon--eye");
                            showPassBtn.classList.remove("da-icon--eye-slash");
                        }
                    });
                }
            </script>

        </div>
    </div>
</main>

@endsection
