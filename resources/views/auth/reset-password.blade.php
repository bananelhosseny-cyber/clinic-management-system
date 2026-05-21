
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="register-form-box">
        <div class="register-form-value">

            <!-- عرض الأخطاء -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @if (collect($errors->all())->contains('expired'))
                        <br>
                        <a href="{{ route('verification.form') }}" class="link-alert">
                            Request a new code
                        </a>
                    @endif
                </div>
            @endif

            <!-- رسالة النجاح -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br><small>Redirecting to login page...</small>
                </div>
            @endif

            <!-- الفورم -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                @if(!empty($email))
                    <p class="info-email">
                        Email: <strong>{{ $email }}</strong>
                    </p>
                    <input type="hidden" name="email" value="{{ $email }}">
                @else
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>
                @endif

                <div class="form-group">
                    <label>Verification Code</label>
                    <input type="text" name="verification_code" placeholder="Enter code" required>
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" placeholder="New password" required>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm password" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit">Reset Password</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- CSS داخلي سريع للتصميم -->
<style>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    font-family: 'Open Sans', sans-serif;
}

.register-form-box {
    display: flex;
    justify-content: center;
    width: 100%;
}

.register-form-value {
    background: #fff;
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0px 5px 20px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 450px;
}

.register-form-value h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 5px;
    font-weight: 600;
    color: #555;
}

.form-group input {
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
}

.btn-submit {
    width: 100%;
    padding: 12px;
    background-color: #33a1e0;
    border: none;
    color: #fff;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background-color: #287bb5;
}

.alert {
    padding: 12px;
    border-radius: 5px;
    margin-bottom: 15px;
    font-weight: bold;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.link-alert {
    color: #721c24;
    text-decoration: underline;
}

.info-email {
    background: #33a1e0;
    padding: 10px;
    border-radius: 5px;
    color: #fff;
    margin-bottom: 20px;
    text-align: center;
    font-weight: 600;
}
</style>
@endsection
