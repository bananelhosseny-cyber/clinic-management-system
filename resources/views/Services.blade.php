<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specialized Medical Services - MediCarely</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Services.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('CSS/normalize.css') }}" />
</head>

<body>
    <nav class="navbar navbar-expand-lg position-sticky top-0 navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand d-lg-none" href="{{ route('home') }}">
                <img src="{{ asset('images/Logo1 Update.png') }}" alt="Logo" width="150px" />
            </a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand d-none d-lg-block" href="{{ route('home') }}">
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
                        <a class="nav-link active" href="{{ route('services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('doctors') }}">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/consultations') }}">Consultations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
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
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <header class="main-header text-center my-5">
            <h1>Expert Medical Care</h1>
            <p>Our specialized departments offer world-class healthcare services using the latest medical innovations and patient-first approach.</p>
        </header>

        <div class="department-group cardio-actions mb-5" id="cardiology-section">
            <section class="medical-section cardiology">
                <div class="info-side">
                    <span class="badge bg-primary">CARDIOLOGY UNIT</span>
                    <h2>Advanced Heart Care</h2>
                    <p>Leading the way in cardiovascular health with precise diagnostics and life-saving interventions.</p>

                    <div class="feature-item">
                        <div class="icon-box"><i class="fas fa-heart-pulse"></i></div>
                        <div class="feature-text">
                            <h3>Heart Rhythm Monitoring</h3>
                            <p>High-precision ECG and Holter monitoring for arrhythmia detection.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="icon-box"><i class="fas fa-vial"></i></div>
                        <div class="feature-text">
                            <h3>Lipid & Cardiac Panels</h3>
                            <p>Comprehensive blood analysis to assess your risk factors instantly.</p>
                        </div>
                    </div>
                </div>
                <div class="image-wrapper">
                    <img src="{{ asset('images/Heart Photo.avif') }}" alt="Heart Scan">
                    <div class="stats-float">
                        <div class="stat-box"><b>99%</b><span>Accuracy</span></div>
                        <div class="stat-box"><b>24/7</b><span>ER Response</span></div>
                    </div>
                </div>
            </section>

            <div class="action-container">
                <div class="cta-card active text-center p-3 shadow-sm">
                    <i class="far fa-calendar-check cta-icon fa-2x mb-2 text-primary"></i>
                    <h3>Heart Screening</h3>
                    <p>Schedule a complete cardiovascular check-up with our senior doctors.</p>
                    <a href="{{ route('cardiology') }}" class="cta-btn solid btn btn-primary">Book Now</a>
                    <span class="meta-text d-block mt-2">Available: Today</span>
                </div>
                <div class="cta-card text-center p-3 shadow-sm">
                    <i class="fas fa-phone-alt cta-icon fa-2x mb-2 text-success"></i>
                    <h3>Emergency Chest Pain</h3>
                    <p>Immediate 24/7 cardiac response for acute heart symptoms.</p>
                    <a href="tel:+2001014394959" class="cta-btn outline btn btn-outline-success">Call Specialist</a>
                    <span class="meta-text d-block mt-2">+20 01014394959</span>
                </div>
                <div class="cta-card text-center p-3 shadow-sm">
                    <i class="fas fa-file-medical cta-icon fa-2x mb-2 text-info"></i>
                    <h3>ECG Review</h3>
                    <p>Get a digital interpretation of your previous heart test results.</p>
                    <a href="#" class="cta-btn outline btn btn-outline-info">Request Review</a>
                    <span class="meta-text d-block mt-2">Response: Immediately</span>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        <div class="department-group ortho-actions mb-5" id="orthopedic-section">
            <section class="medical-section orthopedic">
                <div class="image-wrapper">
                    <img src="{{ asset('images/Doctors Photo serv1.avif') }}" alt="Orthopedic Care">
                    <div class="stats-float">
                        <div class="stat-box"><b>4k+</b><span>Surgeries</span></div>
                        <div class="stat-box"><b>95%</b><span>Mobility Rate</span></div>
                    </div>
                </div>
                <div class="info-side">
                    <span class="badge bg-success">ORTHOPEDIC CENTER</span>
                    <h2>Bone & Joint Specialist</h2>
                    <p>Restoring movement and quality of life through advanced surgical and non-surgical treatments.</p>

                    <div class="feature-item">
                        <div class="icon-box"><i class="fas fa-bone"></i></div>
                        <div class="feature-text">
                            <h3>Joint Replacement</h3>
                            <p>Minimal invasive hip and knee replacements using titanium implants.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="icon-box"><i class="fas fa-child"></i></div>
                        <div class="feature-text">
                            <h3>Sports Medicine</h3>
                            <p>Specialized recovery programs for athletes and sports-related injuries.</p>
                        </div>
                    </div>
                </div>
            </section>
            <div class="action-container">
                <div class="cta-card active text-center p-3 shadow-sm">
                    <i class="fas fa-walking cta-icon fa-2x mb-2 text-success"></i>
                    <h3>Joint Evaluation</h3>
                    <p>Analyze mobility issues or chronic pain with our orthopedic team.</p>
                    <a href="{{ route('orthopedics') }}" class="cta-btn solid btn btn-success">Book Now</a>
                    <span class="meta-text d-block mt-2">Available: EveryDay</span>
                </div>
                <div class="cta-card text-center p-3 shadow-sm">
                    <i class="fas fa-crutch cta-icon fa-2x mb-2"></i>
                    <h3>Injury Support</h3>
                    <p>Fast-track assessment for fractures or sudden sports injuries.</p>
                    <a href="tel:+2001014394959" class="cta-btn outline btn btn-outline-dark">Quick Call</a>
                    <span class="meta-text d-block mt-2">+20 01014394959</span>
                </div>
                <div class="cta-card text-center p-3 shadow-sm">
                    <i class="fas fa-x-ray cta-icon fa-2x mb-2 text-warning"></i>
                    <h3>X-Ray Analysis</h3>
                    <p>Upload your scans for a second opinion on surgical recommendations.</p>
                    <a href="#" class="cta-btn outline btn btn-outline-warning">Upload Files</a>
                    <span class="meta-text d-block mt-2">Response: Immediately</span>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        <div class="department-group dental-actions mb-5" id="dental-section">
            <section class="medical-section dental">
                <div class="info-side">
                    <span class="badge bg-info text-white">DENTAL CLINIC</span>
                    <h2>Smile Restorations</h2>
                    <p>Comprehensive dental care ranging from routine hygiene to complex cosmetic procedures.</p>

                    <div class="feature-item">
                        <div class="icon-box"><i class="fas fa-tooth"></i></div>
                        <div class="feature-text">
                            <h3>Dental Implants</h3>
                            <p>Permanent solutions for missing teeth with natural-looking results.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="icon-box"><i class="fas fa-wand-magic-sparkles"></i></div>
                        <div class="feature-text">
                            <h3>Laser Whitening</h3>
                            <p>Professional whitening that brightens your smile in under 60 minutes.</p>
                        </div>
                    </div>
                </div>
                <div class="image-wrapper">
                    <img src="{{ asset('images/Dentist Photo Serv3.avif') }}" alt="Dental Clinic">
                    <div class="stats-float">
                        <div class="stat-box"><b>100%</b><span>Sterilized</span></div>
                        <div class="stat-box"><b>10yr</b><span>Warranty</span></div>
                    </div>
                </div>
            </section>

            <div class="action-container">
                <div class="cta-card active text-center p-3 shadow-sm">
                    <i class="fas fa-calendar-plus cta-icon fa-2x mb-2 text-info"></i>
                    <h3>Routine Checkup</h3>
                    <p>Book your annual cleaning and deep-exam session.</p>
                    <a href="{{ route('dentist') }}" class="cta-btn solid btn btn-info text-white">Book Now</a>
                    <span class="meta-text d-block mt-2">Available: EveryDay</span>
                </div>
                <div class="cta-card text-center p-3 shadow-sm">
                    <i class="fas fa-comment-medical cta-icon fa-2x mb-2"></i>
                    <h3>Toothache Help</h3>
                    <p>Speak with a dentist immediately for urgent dental pain.</p>
                    <a href="tel:+2001014394959" class="cta-btn outline btn btn-outline-dark">Call Clinic</a>
                    <span class="meta-text d-block mt-2">+20 01014394959</span>
                </div>
                <div class="cta-card text-center p-3 shadow-sm">
                    <i class="fas fa-teeth cta-icon fa-2x mb-2 text-secondary"></i>
                    <h3>Cosmetic Quote</h3>
                    <p>Get a price estimate for veneers, whitening, or implants.</p>
                    <a href="#" class="cta-btn outline btn btn-outline-secondary">Get Quote</a>
                    <span class="meta-text d-block mt-2">Response: Immediately</span>
                </div>
            </div>
        </div>
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
                        <li><a href="{{ route('cardiology') }}">Cardiologist</a></li>
                        <li><a href="{{ route('dentist') }}">Dentist</a></li>
                        <li><a href="{{ route('orthopedics') }}">Orthopedics</a></li>
                    </ul>
                </div>
                <div class="footer-box">
                    <h3>Specialities</h3>
                    <ul>
                        <li><a href="{{ route('orthopedics') }}">Orthopedics</a></li>
                        <li><a href="{{ route('cardiology') }}">Cardiologist</a></li>
                        <li><a href="{{ route('dentist') }}">Dentist</a></li>
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
        <div class="container d-flex justify-content-between">
            <p>© 2026 All Rights Reserved. Designed by MediCarely Team</p>
            <div class="terms d-flex gap-3">
                <p>Terms and Conditions</p>
                <p>Privacy Policy</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/Services.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>