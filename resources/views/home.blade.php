<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home - MediCarely</title>

    <link rel="stylesheet" href="{{ asset('CSS/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('CSS/normalize.css') }}" />
    <link rel="stylesheet" href="{{ asset('CSS/home.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                        <a class="nav-link" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item" id="About">
                        <a class="nav-link" href="{{ url('/about') }}">About</a>
                    </li>
                    <li class="nav-item" id="Services">
                        <a class="nav-link" href="{{ url('/services') }}">Services</a>
                    </li>
                    <li class="nav-item" id="Doctors">
                        <a class="nav-link" href="{{ url('/doctors') }}">Doctors</a>
                    </li>
                    <li class="nav-item" id="Consultations">
                        <a class="nav-link" href="{{ url('/consultations') }}">Consultations</a>
                    </li>
                    <li class="nav-item" id="ContactUs">
                        <a class="nav-link" href="{{ url('/contact') }}">Contact Us</a>
                    </li>
                </ul>

                @guest
                <div class="logout">
                    <a href="{{ route('login') }}"><button class="btn btn-primary me-3" type="button">Login</button></a>
                    <a href="{{ route('register') }}"><button class="btn btn-outline-primary me-5" type="button">Register</button></a>
                </div>
                @else

                <ul class="navbar-nav ms-auto spe profile-icon" id="profileIcon">
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg me-1"></i>
                            <span>{{ Auth::user()->first_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end ms-5" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="{{ url('/profile') }}">
                                    <i class="fas fa-user-circle fa-lg me-1"></i> Account</a>
                            </li>
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
    <section id="up">
        <div>
            <h2>Discover Health : Find Your Trusted Doctors</h2>
            <h5>Join us now and take the first step towards better health!</h5>
            <a href="{{ route('register') }}" class="btcenter"><button class="btn btn-primary btn-lg">Get Started</button></a>
        </div>
        <div>
            <img src="{{ asset('images/img 1.jpg') }}" alt="Home Image" />
        </div>
    </section>
    <h1 class="special">Clinic & Specialities</h1>
    <div class="container">
        <div class="content">
            <div class="box">
                <div class="t-effect">
                    <img src="{{ asset('images/cardiology.jpg') }}" alt="Cardiology" />
                </div>
                <h3>Cardiology</h3>
            </div>
            <div class="box">
                <div class="t-effect">
                    <img src="{{ asset('images/Dentist.jpg') }}" alt="Dentist" />
                </div>
                <h3>Dentist</h3>
            </div>
            <div class="box">
                <div class="t-effect">
                    <img src="{{ asset('images/orthopedics.jpg') }}" alt="Orthopedics" />
                </div>
                <h3>Orthopedics</h3>
            </div>
            <div class="box">
                <div class="t-effect">
                    <img src="{{ asset('images/Portable-Laptop-12-Channel-12-1-Inch-Electrocardiograph-Monitor-ECG-Machine.avif') }}" alt="Gynecology" class="spe" />
                </div>
                <h3>ECG</h3>
            </div>
            <div class="box">
                <div class="t-effect">
                    <img src="{{ asset('images/neurology.jpg') }}" alt="Rays" />
                </div>
                <h3>Rays</h3>
            </div>
            <div class="box">
                <div class="t-effect">
                    <img src="{{ asset('images/Laboratory.jpg') }}" alt="Laboratory" />
                </div>
                <h3>Laboratory</h3>
            </div>
        </div>
    </div>
    <h1 class="special">Our Highlighted Doctors</h1>
    <div class="container">
        <div class="doctors">
            <div class="doc-card">
                <div class="media">
                    <div class="rating"><span class="star">★</span> 4.8</div>
                </div>
                <img src="{{ asset('images/cardiology Doc.jpg') }}" alt="Doctor 1" />
                <p class="available">Available</p>
                <h3>Dr. John Smith</h3>
                <p class="specify">Cardiologist</p>
                <div class="consult">
                    <div class="price">
                        <p>Consultations Fees</p>
                        <span>$150</span>
                    </div>
                    <div class="book">
                        <a href="{{ route('cardiology') }}"><button class="btn">Book Now</button></a>
                    </div>
                </div>
            </div>
            <div class="doc-card">
                <div class="media">
                    <div class="rating"><span class="star">★</span> 3.5</div>
                </div>
                <img src="{{ asset('images/Dentist Doc.jpg') }}" alt="Doctor 2" />
                <p class="available">Available</p>
                <h3>Dr. ruby perrin</h3>
                <p class="specify">Dentist</p>
                <div class="consult">
                    <div class="price">
                        <p>Consultations Fees</p>
                        <span>$150</span>
                    </div>
                    <div class="book">
                        <a href="{{ route('dentist') }}"><button class="btn">Book Now</button></a>
                    </div>
                </div>
            </div>
            <div class="doc-card">
                <div class="media">
                    <div class="rating"><span class="star">★</span> 4.0</div>
                </div>
                <img src="{{ asset('images/Orthopedics Doc.jpg') }}" alt="Doctor 3" />
                <p class="available">Available</p>
                <h3>Dr. Mahmoud Ahmed</h3>
                <p class="specify">Orthopedics</p>
                <div class="consult">
                    <div class="price">
                        <p>Consultations Fees</p>
                        <span>$150</span>
                    </div>
                    <div class="book">
                        <a href="{{ route('orthopedics') }}"><button class="btn">Book Now</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="step-section">
        <section class="how-it-works">
            <div class="container">
                <div class="left">
                    <img src="{{ asset('images/Step.png') }}" alt="Doctor" />
                </div>
                <div class="right">
                    <h4 class="small-title">How it Works</h4>
                    <h2 class="main-title">4 easy steps to get your solution</h2>
                    <div class="steps">
                        <div class="step">
                            <div class="icon"><img src="{{ asset('images/search.svg') }}" alt="" /></div>
                            <h3>Search Doctor</h3>
                            <p>Search for a doctor based on specialization or availability.</p>
                        </div>
                        <div class="step">
                            <div class="icon"><img src="{{ asset('images/check.svg') }}" alt="" /></div>
                            <h3>Check Doctor Profile</h3>
                            <p>Explore detailed doctor profiles on our platform to make informed healthcare decisions.</p>
                        </div>
                        <div class="step">
                            <div class="icon"><img src="{{ asset('images/schedule.svg') }}" alt="" /></div>
                            <h3>Schedule Appointment</h3>
                            <p>After choosing your preferred doctor, select a convenient time slot, & confirm your appointment.</p>
                        </div>
                        <div class="step">
                            <div class="icon"><img src="{{ asset('images/solution.svg') }}" alt="" /></div>
                            <h3>Get Your Solution</h3>
                            <p>Discuss your health concerns with the doctor and receive personalized advice & solution.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <nav class="test">
        <h1 class="special">Testimonial</h1>
        <h3 style="text-align: center">What Our Patients Say</h3>
        <div class="container">
            <div class="testimonials">
                <div class="testimonial-card">
                    <div class="rating">★★★★★</div>
                    <h6>Nice Treatment</h6>
                    <p>"The doctors here are amazing! They took great care of me and made me feel comfortable throughout my treatment. Thanks a lot."</p>
                    <div class="image">
                        <img src="{{ asset('images/Patient-1.jpeg') }}" alt="Patient 1" />
                        <h5>Ahmed L.</h5>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="rating">★★★★☆</div>
                    <h6>Good Hospitality</h6>
                    <p>"I had a wonderful experience at this clinic. The staff was friendly and professional, and the facilities were top-notch."</p>
                    <div class="image">
                        <img src="{{ asset('images/Patient-2.jpg') }}" alt="Patient 2" />
                        <h5>Sara R.</h5>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="rating">★★★★★</div>
                    <h6>Nice Treatment</h6>
                    <p>"I highly recommend this clinic to anyone in need of medical care. The doctors are knowledgeable and compassionate."</p>
                    <div class="image">
                        <img src="{{ asset('images/Patient-3.jpeg') }}" alt="Patient 3" />
                        <h5>Jack T.</h5>
                    </div>
                </div>
            </div>
            <div class="client">
                <div class="client-Feautres">
                    <p class="one num" data-goal="50">0</p>
                    <h5>Doctor Available</h5>
                </div>
                <div class="client-Feautres">
                    <p class="two num" data-goal="20">0</p>
                    <h5>Specialities</h5>
                </div>
                <div class="client-Feautres">
                    <p class="three num" data-goal="450">0</p>
                    <h5>Booking Done</h5>
                </div>
                <div class="client-Feautres">
                    <p class="four num" data-goal="15">0</p>
                    <h5>Hospital & Clinic</h5>
                </div>
                <div class="client-Feautres">
                    <p class="five num" data-goal="317">0</p>
                    <h5>Lab Test Available</h5>
                </div>
            </div>
        </div>
    </nav>
    <div class="scan">
        <div class="container">
            <div class="scan-content">
                <h2>Scan QR Code To Display On Mobile</h2>
                <img src="{{ asset('images/QR Code.jpg') }}" alt="QR Code" />
            </div>
            <div class="images">
                <img src="{{ asset('images/mobile-App.png') }}" alt="Mobile Display" />
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-box">
                    <h3>Documentation</h3>
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
    <a href="#up">
        <div class="up">
            <i class="fa-solid fa-circle-up"></i>
        </div>
    </a>

    <script src="{{ asset('java/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>