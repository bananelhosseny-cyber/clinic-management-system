<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors - MediCarely</title>

    <link rel="stylesheet" href="{{ asset('CSS/Doctors.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('CSS/normalize.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg position-sticky top-0 navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/Logo1 Update.png') }}" alt="Logo" width="150px" />
            </a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 item">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ url('/doctors') }}">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/consultations') }}">Consultations</a></li>
                    <li class="nav-item"><a class="nav-link " href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>

                @guest
                <div class="logout">
                    <a href="{{ route('login') }}"><button class="btn btn-primary me-3" type="button">Login</button></a>
                    <a href="{{ route('register') }}"><button class="btn btn-outline-primary me-5" type="button">Register</button></a>
                </div>
                @else
                <ul class="navbar-nav ms-auto spe profile-icon" id="profileIcon">
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg me-1"></i>
                            <span>{{ Auth::user()->first_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <!-- <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="fas fa-user-circle me-1"></i> Account</a></li> -->
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
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
    </nav>

    <section class="hero">
        <h1>Doctors</h1>
    </section>

    <section class="doctors">
        <div class="section-title">
            <span>OUR DOCTORS</span>
            <h2 style="width: fit-content; border-bottom: 2px solid #3b82f6; margin: 15px auto;">Our Specialist</h2>
        </div>

        <div class="filter-buttons">
            <button class="active" data-filter="all">All</button>
            <button data-filter="cardio">Cardiology</button>
            <button data-filter="ortho">Orthopedic</button>
            <button data-filter="dent">Dentist</button>
        </div>

        <div class="cards">
            <div class="card" data-category="cardio">
                <div class="image">
                    <a href="{{ url('/details/cardiology') }}">
                        <img src="{{ asset('images/cardiology Doc.jpg') }}" alt="Dr. John Smith">
                    </a>
                </div>
                <div class="info">
                    <h3>Dr. John Smith</h3>
                    <p>Cardiologist</p>
                    <div class="social">
                        <i class="fab fa-twitter"></i>
                        <i class="fab fa-facebook-f"></i>
                        <i class="fab fa-instagram"></i>
                        <i class="fab fa-linkedin-in"></i>
                    </div>
                </div>
            </div>

            <div class="card active" data-category="ortho">
                <div class="image">
                    <a href="{{ url('/details/orthopedics') }}">
                        <img src="{{ asset('images/Orthopedics Doc.jpg') }}" alt="Dr. Mahmoud Ahmed">
                    </a>
                </div>
                <div class="info">
                    <h3>Dr. Mahmoud Ahmed</h3>
                    <p>Orthopedic</p>
                    <div class="social">
                        <i class="fab fa-twitter"></i>
                        <i class="fab fa-facebook-f"></i>
                        <i class="fab fa-instagram"></i>
                        <i class="fab fa-linkedin-in"></i>
                    </div>
                </div>
            </div>

            <div class="card" data-category="dent">
                <div class="image">
                    <a href="{{ url('/details/dentist') }}">
                        <img src="{{ asset('images/Dentist Doc.jpg') }}" alt="Dr. Ruby Perrin">
                    </a>
                </div>
                <div class="info">
                    <h3>Dr. Ruby Perrin</h3>
                    <p>Dentist</p>
                    <div class="social">
                        <i class="fab fa-twitter"></i>
                        <i class="fab fa-facebook-f"></i>
                        <i class="fab fa-instagram"></i>
                        <i class="fab fa-linkedin-in"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        <li><a href="#">Neurology</a></li>
                        <li><a href="#">Cardiologist</a></li>
                        <li><a href="#">Dentist</a></li>
                    </ul>
                </div>
                <div class="footer-box">
                    <h3 class="me">Utilities</h3>
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
                        <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright">
        <p>© {{ date('Y') }} All Rights Reserved. Designed by MediCarely Team</p>
        <div class="terms">
            <p>Terms and Conditions</p>
            <p>Privacy Policy</p>
        </div>
    </div>

    <script src="{{ asset('Java/Doctors.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>