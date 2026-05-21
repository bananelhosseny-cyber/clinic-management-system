<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - MediCarely</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/Contact.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg position-sticky top-0 navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand d-lg-none" href="{{ url('/') }}">
                <img src="{{ asset('images/Logo1 Update.png') }}" alt="Logo" width="150px" />
            </a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand d-none d-lg-block" href="{{ url('/') }}">
                    <img src="{{ asset('images/Logo1 Update.png') }}" alt="Logo" width="150px" />
                </a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 item">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/doctors') }}">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/consultations') }}">Consultations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/contact') }}">Contact Us</a>
                    </li>
                </ul>

                <div class="logout d-flex align-items-center">
                    @guest
                    <a href="{{ route('login') }}"><button class="btn btn-primary me-3" type="button">Login</button></a>
                    <a href="{{ route('register') }}"><button class="btn btn-outline-primary me-5" type="button">Register</button></a>
                    @else
                    <ul class="navbar-nav ms-auto profile-icon" id="profileIcon">
                        <li class="nav-item dropdown me-5">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle fa-lg me-1"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="fas fa-user-circle me-1"></i> Account</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-right-from-bracket"></i> Log-out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="contact-section-header fade-up text-center my-5">
        <h2 class="contact-section-title">Contact Us</h2>
        <p class="contact-section-description">
            Great doctor if you need your family member to get effective immediate assistance.
        </p>
    </div>

    <div class="container contact-info-wrapper fade-up">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="contact-info-card p-4 shadow-sm">
                    <i class="fa fa-phone contact-icon mb-3 fs-3 text-primary"></i>
                    <h5 class="contact-info-title">Phone Number</h5>
                    <p class="contact-info-text">+20 01014394959</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="contact-info-card p-4 shadow-sm">
                    <i class="fa fa-envelope contact-icon mb-3 fs-3 text-primary"></i>
                    <h5 class="contact-info-title">Email</h5>
                    <p class="contact-info-text">Medicarelyclinic@gmail.com</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="contact-info-card p-4 shadow-sm">
                    <i class="fa fa-map-marker-alt contact-icon mb-3 fs-3 text-primary"></i>
                    <h5 class="contact-info-title">Location</h5>
                    <p class="contact-info-text">3556 Beech Street, Minia</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container contact-main-section fade-up my-5">
        <div class="row g-4">
            <div class="col-md-6 contact-map-container">
                <iframe class="contact-map-frame w-100" height="450" style="border:0;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55565.4123!2d30.7503!3d28.0871!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145b23447c21f92d%3A0x67a9985b46d3e86c!2sMinya%2C%20Egypt!5e0!3m2!1sen!2s!4v1710000000000"
                    allowfullscreen="" loading="lazy"></iframe>
            </div>

            <div class="col-md-6 contact-form-container">
                <h6 class="contact-form-subtitle text-primary">GET IN TOUCH</h6>
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <h2 class="contact-form-title mb-4">Contact Details</h2>

                <form action="{{ url('/contact-send') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="first_name" class="form-control contact-form-input" placeholder="Enter First Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="last_name" class="form-control contact-form-input" placeholder="Enter Last Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control contact-form-input" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="phone" class="form-control contact-form-input" placeholder="Phone Number">
                        </div>
                        <div class="col-12">
                            <textarea name="message" class="form-control contact-form-textarea" rows="5" placeholder="Enter Message" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 contact-submit-button">SUBMIT</button>

                        </div>
                    </div>
                </form>
            </div>
            <div class="footer">
                <div class="container">
                    <div class="footer-content">
                        <div class="footer-box">
                            <h3>Doctors</h3>
                            <ul>
                                <li><a href="#">Medical</a></li>
                                <li><a href="#">Operation</a></li>
                                <li><a href="#">Laboratory</a></li>
                            </ul>
                        </div>
                        <div class="footer-box">
                            <h3>Treatments</h3>
                            <ul>
                                <li><a href="#">Cardiologist</a></li>
                                <li><a href="#">Dentist</a></li>
                                <li><a href="#">Neurology</a></li>
                            </ul>
                        </div>
                        <div class="footer-box">
                            <h3>Specialities</h3>
                            <ul>
                                <li><a href="#">Cardiologist</a></li>
                                <li><a href="#">Neurology</a></li>
                                <li><a href="#">Dentist</a></li>
                            </ul>
                        </div>
                        <div class="footer-box">
                            <h3 class="me">Utilites</h3>
                            <ul>
                                <li><a href="#">Operation</a></li>
                                <li><a href="#">Laboratory</a></li>
                                <li><a href="#">Medical</a></li>
                            </ul>
                        </div>
                        <div class="footer-box">
                            <h3>Contact Us</h3>
                            <p>Working for Your Better Health.</p>
                            <p>Contact With Us</p>
                            <ul class="social">
                                <li>
                                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>© 2025 All Rights Reserved. Designed by MediCarely Team</p>
                <div class="terms">
                    <p>Terms and Conditions</p>
                    <p>Privacy Policy</p>
                </div>
            </div>
            </footer>

            <script src="{{ asset('js/Contact.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>