@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Register || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main class="register-page page--form">
    <div class="content">
        <a href="{{ route('home') }}">
            <div class="image-block">
                <img src="/images/logos/logo.svg"/>
            </div>
        </a>
        <div class="form">
            <form method="post" action="{{ route('register.post') }}">
                @csrf
                <h2>Register</h2>
                <div class="link">
                    <hr>
                    <h5>
                        REGISTER WITH EMAIL
                    </h5>
                    <hr>
                </div>
                <div>
                    <h4>Email</h4>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <h4>Name</h4>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="passBox">
                    <h4>Password</h4>
                    <input type="password" name="password" class="password" required>
                    <a class="showPass" onclick="showPass()"><i class="showPassBtn da-icon da-icon--eye"></i></a>
                </div>
                @if(!empty($errors->all()) || isset($error))
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="errors"><?= $error; ?></p>
                        @endforeach
                    </div>
                @endif
                <div class="link">
                    <button class="btn btn--primary" type="submit" name="register">Register</button>
                </div>
                <div class="link">
                    <hr>
                    <h5>
                        <a href="{{ route('login') }}">LOGIN</a>
                    </h5>
                    <hr>
                </div>
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
