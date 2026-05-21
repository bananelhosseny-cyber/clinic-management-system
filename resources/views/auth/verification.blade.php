<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <link rel="stylesheet" href="{{ asset('CSS/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/verification.css') }}">
</head>

<body>

<div class="login">
  <div class="content">
    <h1>Verification</h1>
    <div class="sec-logo">
      <a href="{{ url('/') }}">Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('login') }}">Login</a>
    </div>
  </div>
</div>

<div class="container">
    <div class="box">

        <div class="img">
            <img src="{{ asset('images/login-banner.png') }}" alt="">
        </div>

        <div class="message">

            {{-- عرض الرسائل --}}
            @if(session('success'))
                <div style="padding:15px; background:#d4edda; color:#155724; border-radius:5px; margin-bottom:15px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="padding:15px; background:#f8d7da; color:#721c24; border-radius:5px; margin-bottom:15px;">
                    {{ session('error') }}
                </div>
            @endif

            <h2>Reset Your Password</h2>
            <p>Enter your email and we will send you a reset link with a verification code.</p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <label>Email Address <span>*</span></label>
                <input type="email" name="email" required value="{{ old('email') }}">

                <button type="submit" id="btn">Send Reset Link</button>
            </form>

        </div>

    </div>
</div>

</body>
</html>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

