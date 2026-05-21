<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('CSS/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('CSS/normalize.css') }}" />
    <link rel="stylesheet" href="{{ asset('CSS/login.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <title>Login / Register</title>
</head>

<body>
    <div class="login">
        <div class="content">
            <h1>Login</h1>
            <div class="sec-logo">
                <a href="{{ url('/home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ url('/login') }}">Login</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="parent">

            <!-- Login Form -->
            <div class="form-box log-in">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h1>Login</h1>

                    @if(session('error'))
                    <div style="color:red; margin-bottom:10px;">{{ session('error') }}</div>
                    @endif

                    @if(session('success'))
                    <div style="color:green; margin-bottom:10px;">{{ session('success') }}</div>
                    @endif

                    <div class="input-box">
                        <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}" />
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div class="input-box registerationInput">
                        <input type="password" name="password" placeholder="Password" required id="login-password" />
                        <i class="fa-solid fa-eye-slash" id="login-eye-slash" onclick="show('login')"></i>
                        <i class="fa-solid fa-eye" id="login-eye" onclick="show('login')"></i>
                    </div>

                    <div class="forget">
                        <div class="remember">
                            <input id="remember" type="checkbox" name="remember" class="scl" />
                            <label for="remember">Remember Me</label>
                        </div>
                        <a href="{{ route('verification.form') }}">Forget Password?</a>
                    </div>

                    <div id="auth-action-area">
                        @if(session('lockout_time'))
                        {{-- في حالة الحظر: الزرار يختفي ويظهر التنبيه --}}
                        <div style="color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; text-align: center; font-weight: bold;">
                            Too many attempts. <br>
                            Try again in <span id="countdown-timer">{{ session('lockout_time') }}</span> seconds.
                        </div>
                        @else
                        {{-- الحالة الطبيعية: الزرار يظهر --}}
                        <button type="submit" class="btn">Log-in</button>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Registration Form -->
            <div class="form-box register">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h1>Registration</h1>

                    @if($errors->any())
                    <div style="color:red; margin-bottom:10px; font-weight:bold; padding:10px; border-radius:5px; background:#f8d7da;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="select">
                        <div class="doctor">
                            <input id="doctor" type="radio" name="user_type" value="doctor" class="scl" />
                            <label for="doctor">Doctor</label>
                        </div>
                        <div class="patient">
                            <input id="patient" type="radio" name="user_type" value="patient" class="scl" />
                            <label for="patient">Patient</label>
                        </div>
                    </div>

                    <div class="input-box special">
                        <input type="text" name="first_name" placeholder="First Name" required value="{{ old('first_name') }}" />
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div class="input-box special">
                        <input type="text" name="last_name" placeholder="Last Name" required value="{{ old('last_name') }}" />
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div class="input-box">
                        <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}" />
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div class="input-box registerationInput">
                        <input type="password" name="password" placeholder="Password" required id="register-password" class="pass" />
                        <i class="fa-solid fa-eye-slash" id="register-eye-slash" onclick="show('register')"></i>
                        <i class="fa-solid fa-eye" id="register-eye" onclick="show('register')"></i>
                    </div>
                    <div class="passAlert" id="passAlert">
                        <div>Password Must Contains At least</div>
                        <div id="xmarkCapital"><span><i class="fa-solid fa-xmark"></i></span><span>One Capital Letter</span></div>
                        <div id="xmarkSmall"><span><i class="fa-solid fa-xmark"></i></span><span>One Small Letter</span></div>
                        <div id="xmarkNumbers"><span><i class="fa-solid fa-xmark"></i></span><span>One Number</span></div>
                        <div id="xmarkSymbol"><span><i class="fa-solid fa-xmark"></i></span><span>One Symbol</span></div>
                        <div id="xmarkLength"><span><i class="fa-solid fa-xmark"></i></span><span>8 digits length</span></div>
                    </div>
                    <div class="input-box passwordConfirmation">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required id="passwordConfirmation" />
                    </div>
                    <div class="passConfirmAlert" id="passConfirmAlert"></div>
                    <div class="input-box">
                        <input type="date" name="birthdate" required value="{{ old('birthdate') }}" />
                    </div>

                    <button type="submit" class="btn">Register</button>
                </form>
            </div>

            <!-- Toggle Panels -->
            <div class="toogle-box">
                <div class="toogle-panel toogle-left">
                    <h1>Welcome Back !</h1>
                    <p>Don`t Have An Account ?</p>
                    <button class="btn btn-register">Register</button>
                </div>
                <div class="toogle-panel toogle-right">
                    <h1>Welcome !</h1>
                    <p>Do You Have Account ?</p>
                    <button class="btn btn-login">Log-in</button>
                </div>
            </div>
        </div>
    </div>
    <script src="Java/login.js"></script>
    @if(session('lockout_time'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let seconds = {
                {
                    session('lockout_time')
                }
            };
            const timerSpan = document.getElementById('countdown-timer');

            const interval = setInterval(() => {
                seconds--;
                if (timerSpan) timerSpan.innerText = seconds;

                if (seconds <= 0) {
                    clearInterval(interval);
                    window.location.reload();
                }
            }, 1000);
        });
    </script>
    @endif
</body>

</html>