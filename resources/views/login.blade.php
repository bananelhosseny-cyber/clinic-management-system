<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Font Awesome Library -->
    <link rel="stylesheet" href="CSS/all.min.css" />
    <!-- Render All Element Normally -->
    <link rel="stylesheet" href="CSS/normalize.css" />
    <!-- Main CSS File -->
    <link rel="stylesheet" href="CSS/login.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <title>Log-in</title>
</head>

<body>
    <div class="login">
        <div class="content">
            <h1>Login</h1>
            <div class="sec-logo">
                <a href="Home.html">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <p>Login</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="parent">
            <div class="form-box log-in">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h1>Login</h1>
                    <div class="input-box">
                        <input type="email" placeholder="Email" required />
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="input-box registerationInput">
                        <input type="password" placeholder="Password" required id="login-password" />
                        <i class="fa-solid fa-eye-slash" id="login-eye-slash" onclick="show('login')"></i>
                        <i class="fa-solid fa-eye" id="login-eye" onclick="show('login')"></i>
                    </div>
                    <div class="forget">
                        <div class="remember">
                            <input id="remember" type="checkbox" name="remember" value="Remember Me" class="scl" />
                            <label for="remember">Remember Me</label>
                        </div>
                        <a href="verification.html">Forget Password ?</a>
                    </div>
                    <div id="action-area">
                </form>

            </div>
            <div class="form-box register">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h1>Registration</h1>
                    <div class="select">
                        <div class="doctor">
                            <input id="doctor" type="radio" name="user-type" class="scl" />
                            <label for="doctor">Doctor</label>
                        </div>
                        <div class="patient">
                            <input id="patient" type="radio" name="user-type" class="scl" />
                            <label for="patient">patient</label>
                        </div>
                    </div>
                    <div class="input-box special">
                        <input type="text" placeholder="First Name" required />
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="input-box special">
                        <input type="text" placeholder="Last Name" required />
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="email" placeholder="Email" required />
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="input-box registerationInput">
                        <input type="password" placeholder="Password" required id="register-password" class="pass" />
                        <i class="fa-solid fa-eye-slash" id="register-eye-slash" onclick="show('register')"></i>
                        <i class="fa-solid fa-eye" id="register-eye" onclick="show('register')"></i>
                    </div>
                    <div class="input-box passwordConfirmation">
                        <input type="password" placeholder="Confirm Password" required id="passwordConfirmation" />
                    </div>
                    <div id="passConfirmAlert" class="passConfirmAlert">
                        <span><i class="fa-solid fa-xmark"></i></span><span>Password Are Not matches</span>
                    </div>
                    <div class="input-box">
                        <input type="date" placeholder="BirthDay" required />
                    </div>
                    <button type="submit" class="btn">Register</button>
                </form>
            </div>
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
</body>

</html>