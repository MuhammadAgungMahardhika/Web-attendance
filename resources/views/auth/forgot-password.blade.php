@extends('template.layout-1-column.main')
@section('container')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <input class="form-check-input  me-0" type="hidden" id="toggle-dark">
                <div id="auth-left">
                    <a href=""><img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="120"></a>
                    <h1 class="auth-title">Forgot Password.</h1>
                    <p class="auth-subtitle mb-5">Enter your email address to reset password</p>
                    <div id="loginForm">
                        <div class="form-group position-relative has-icon-left ">
                            <input class="form-control form-control-xl" type="email" name="email" placeholder="Email"
                                id="email">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <button type="submit" onclick="login()" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
                            id="btnLogin">Reset password</button>
                        <a type="submit" href="{{ url('login') }}" class="mt-4" id="btnLogin">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script></script>
@endsection
