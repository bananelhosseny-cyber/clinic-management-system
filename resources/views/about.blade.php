<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Clinic Page</title>

    <link rel="stylesheet" href="{{ asset('css/About.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg position-sticky top-0 navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand right-0 navbar-toggler border-0" href="{{ url('/') }}">
                <img src="{{ asset('images/Logo1 Update.png') }}" alt="Logo" width="150px" />
            </a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/Logo1 Update.png') }}" alt="Logo" width="150px" />
                </a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 item">
                    <li class="nav-item" id="Home">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item" id="About">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item" id="Services">
                        <a class="nav-link" href="{{ route('services') }}">Services</a>
                    </li>
                    <li class="nav-item" id="Doctors">
                        <a class="nav-link" href="{{ route('doctors') }}">Doctors</a>
                    </li>
                    <li class="nav-item" id="Consultations">
                        <a class="nav-link" href="{{ route('consultations') }}">Consultations</a>
                    </li>
                    <li class="nav-item" id="ContactUs">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
                @guest
                <a href="{{ route('login') }}"><button class="btn btn-primary me-3" type="button">Login</button></a>
                <a href="{{ route('register') }}"><button class="btn btn-outline-primary me-5" type="button">Register</button></a>
                @else

                <ul class="navbar-nav ms-auto profile-icon" id="profileIcon">
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg me-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="{{ url('/profile') }}">
                                    <i class="fas fa-user-circle fa-lg me-1"></i> Account</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
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

                </li>
                </ul>
                </li>
                </ul>
            </div>
        </div>

    </nav>

    <section class="header-banner">
        <h1>About Us</h1>
        <p><a href="{{ url('/home') }}">Home</a>> <span><a href="{{ url('/about') }}">about us</a></span></p>
    </section>
    <section class="about-container">
        <div class="about-text">
            <h2>About our Clinic</h2>
            <p>At our multi-disciplinary clinic, we bridge the gap between advanced technology and compassionate care. Our <b>Cardiology</b> department utilizes state-of-the-art diagnostics to ensure your heart is in the strongest hands.</p>
            <p>For those seeking mobility, our <b>Orthopedics</b> team specializes in both surgical and non-surgical treatments to get you back on your feet. Meanwhile, our <b>Dentistry</b> wing focuses on restorative and cosmetic oral health for a smile that lasts a lifetime.</p>
            <p>We believe in a holistic approach to medicine, ensuring every patient receives a personalized plan tailored to their unique physiological needs.</p>
        </div>
        <div class="about-images">
            <div class="img-box top-img">
                <img src="{{ asset('images/lab-image-1.jpg') }}" alt="Lab Image">
            </div>
            <div class="img-box bottom-img">
                <img src="{{ asset('images/pharmacylab.jpg') }}" alt="Pharmacy Lab">
            </div>
        </div>
    </section>

    <section class="why-choose-us">
        <h2>Why Choose Us</h2>
        <div class="card-grid">
            <div class="feature-card">
                <div class="icon-circle"><i class="fas fa-user-md"></i></div>
                <h3>Qualified Doctors</h3>
                <p>Our specialists in Cardiology, Orthopedics, and Dentistry are board-certified leaders in their fields.</p>
            </div>
            <div class="feature-card">
                <div class="icon-circle"><i class="fas fa-clock"></i></div>
                <h3>24 Hours Service</h3>
                <p>Emergency cardiac and orthopedic care available around the clock to ensure your safety.</p>
            </div>
            <div class="feature-card">
                <div class="icon-circle"><i class="fas fa-microscope"></i></div>
                <h3>Quality Lab Services</h3>
                <p>On-site diagnostic imaging and blood work for faster, more accurate medical results.</p>
            </div>
            <div class="feature-card">
                <div class="icon-circle"><i class="fas fa-comments"></i></div>
                <h3>Free Consultations</h3>
                <p>Your journey begins with a free initial screening to determine the best path for your health.</p>
            </div>
        </div>
    </section>

    <section class="looking-for-section">
        <div class="container">
            <div class="section-header">
                <h2>What are you <span class="blue-text">looking</span> for?</h2>
            </div>
            <div class="services-wrapper">
                <div class="service-card active-on-hover">
                    <div class="service-content">
                        <i class="fas fa-heartbeat service-icon"></i>
                        <h3>Heart Care Services</h3>
                        <p>Schedule comprehensive cardiac check-ups, ECGs, and stress tests with our top cardiologists.</p>
                        <a href="{{ route('cardiology') }}" class="book-now">Book Now <span>&rarr;</span></a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-content">
                        <i class="fas fa-bone service-icon"></i>
                        <h3>Orthopedic Consultations</h3>
                        <p>Get expert analysis for joint pain, sports injuries, and spine health with our orthopedists.</p>
                        <a href="{{ route('orthopedics') }}" class="book-now">Book Now <span>&rarr;</span></a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-content">
                        <i class="fas fa-tooth service-icon"></i>
                        <h3>Dental Appointments</h3>
                        <p>Book a general cleaning, cosmetic procedures, or advanced dental surgery with our surgeons.</p>
                        <a href="{{ route('dentist') }}" class="book-now">Book Now <span>&rarr;</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2>Available Features <span>in Our Clinic</span></h2>
                <p>Our facility is equipped with specialized infrastructure for heart care, bone health, and oral surgery, ensuring comprehensive treatment under one roof.</p>
            </div>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-img">
                        <img src="{{ asset('images/operation.jpg') }}" alt="Operation">
                        <div class="feature-label">Operation</div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-img">
                        <img src="{{ asset('images/laboratory.jpg') }}" alt="Laboratory">
                        <div class="feature-label">Laboratory</div>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-img">
                        <img src="{{ asset('images/ICU.jpg') }}" alt="ICU">
                        <div class="feature-label">ICU</div>
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
                        <li><a href="{{ route('orthopedics') }}">Orthopedics</a></li>
                        <li><a href="{{ route('cardiology') }}">Cardiologist</a></li>
                        <li><a href="{{ route('dentist') }}">Dentist</a></li>
                    </ul>
                </div>
                <div class="footer-box">
                    <h3>Specialities</h3>
                    <ul>
                        <li><a href="#">Orthopedics</a></li>
                        <li><a href="#">Cardiologist</a></li>
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
        <p>© 2026 All Rights Reserved. Designed by MediCarely Team</p>
        <div class="terms">
            <p>Terms and Conditions</p>
            <p>Privacy Policy</p>
        </div>
    </div>

    <script src="{{ asset('js/About.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>