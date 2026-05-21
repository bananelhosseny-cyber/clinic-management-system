<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <link rel="stylesheet" href="{{ asset('assets/CSS/all.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/CSS/normalize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/CSS/verification.css') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="login">
      <div class="content">
        <h1>Verification</h1>
        <div class="sec-logo">
          <a href="{{ route('/') }}">Home</a>
          <i class="fa-solid fa-chevron-right"></i>
          <p>Login</p>
        </div>
      </div>
    </div>
    
    <div class="container">
        <div class="box">
            <div class="img">
                <img src="{{ asset('assets/images/login-banner.png') }}" alt="">
            </div>
            
            <div class="message">
                <h2>Reset Your Password</h2>
                <p>Enter your email and we will send you a link to reset your password.</p>

                @if (session('status'))
                    <div style="color: green; font-weight: bold; margin-bottom: 20px;">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf 

                    <label for="email">Email Address <span>*</span></label>
                    <input type="email" id="email" name="email" required autofocus>

                    @error('email')
                        <div class="emailAlert" id="emailAlert" style="display: block;">
                            <span><i class="fa-solid fa-circle-exclamation" style="color: black"></i></span>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <button type="submit" id="resetPassword">Send Reset Link</button>
                </form>

                <p class="back-to-login">
                    <a href="{{ route('login') }}">Back to Login</a>
                </p>

            </div>
        </div>
    </div>

    </body>
</html>


