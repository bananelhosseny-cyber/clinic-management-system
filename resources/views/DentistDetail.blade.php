<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('CSS/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('CSS/normalize.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('CSS/DentistDetail.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg position-sticky top-0 navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand right-0 navbar-toggler border-0" href="#"><img src="{{ asset('images/Logo1 Update.png') }}" alt="" width="150px" /></a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#"><img src="{{ asset('images/Logo1 Update.png') }}" alt="" width="150px" /></a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 item">
                    <li class="nav-item" id="Home">
                        <a class="nav-link" aria-current="page" href="{{ url('/home') }}">Home</a>
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
                <ul class="navbar-nav ms-auto spe profile-icon" id="profileIcon">
                    @auth
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg me-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end ms-5" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="{{ url('/Profile') }}">
                                    <i class="fas fa-user-circle fa-lg me-1"></i> Account</a>
                            </li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket"></i> Log-out
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endauth

                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                    @endguest
                </ul>
                </li>
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="page-header">
        <h1>Dr. Ruby Perrin</h1>
    </section>

    <section class="doctor-profile">
        <div class="profile-card">
            <div class="left">
                <img src="{{ asset('images/Dentist Doc.jpg') }}">
            </div>
            <div class="middle">
                <h2>Dr Ruby Perrin <i class="fa fa-check-circle verified"></i></h2>
                <p class="speciality">Dentist</p>
                <p><i class="fa fa-user"></i> 1200+ Patients Treated</p>
                <p><strong>Clinic:</strong> The Family Dentistry Clinic</p>
                <p><strong>Location:</strong> Egypt</p>
            </div>
            <div class="right">
                <p><i class="fa fa-map-marker-alt"></i> Central Center, Tower 1, Pre Plaza, First Floor, 6th of October, Giza, Egypt</p>
                <p><i class="fa fa-phone"></i> 01030498686</p>
                <p><i class="fa fa-money-bill"></i> Consultation Fee: 200 EGP</p>
                <button class="outline">Add Feedback</button>
                <a href="{{ route('dentist') }}"><button class="primary">Book Appointment</button></a>
            </div>
        </div>
    </section>

    <section class="tabs-section">
        <div class="tabs">
            <button class="tab active" data-tab="overview">Overview</button>
            <button class="tab" data-tab="reviews">Reviews</button>
        </div>
        <div class="tab-content active" id="overview">
            <h3>About Dr Ruby perrin</h3>
            <p style="font-size: 16px;">
                Dr. Ruby Perrin – Dentist
                Dr. Ruby Perrin is a highly skilled and dedicated Dentist with over 10 years of experience in providing exceptional dental care. She is committed to improving patients’ oral health and enhancing their smiles through advanced dental techniques and personalized treatment plans.<br><br>

                <span style="color: red; font-size: 18px;">Areas of Expertise:</span><br>
                Cosmetic Dentistry (veneers, teeth whitening, smile makeovers)
                Root Canal Treatment
                Dental Surgery and Extractions
                Preventive and Restorative Dentistry
                Pediatric Dentistry (child dental care)
                Dental Implants and Prosthetics<br><br>
                <span style="color: red; font-size: 18px;">Professional Experience:</span><br>
                Dr. Perrin has successfully treated thousands of patients, focusing on delivering painless, precise, and long-lasting dental solutions. Her approach combines the latest dental technologies with compassionate care, ensuring that each patient receives a comfortable and positive experience.<br><br>
                <span style="color: red; font-size: 18px;">Education & Certifications:</span><br>
                Doctor of Dental Surgery (DDS), MUST University
                Certified in Advanced Cosmetic Dentistry
                Continuing education in Laser Dentistry and Implantology
                Member of Egyptian Dental Association (EDA)<br><br>

                <span style="color: red; font-size: 18px;">Professional Skills:</span><br>
                Strong patient communication and counseling
                Expertise in diagnostic imaging and treatment planning
                Skilled in modern dental tools and technology
                Leadership in clinical dental teams and training<br><br>

                <span style="color: red; font-size: 18px;">Achievements:</span><br>
                Recognized for excellence in cosmetic dentistry and patient satisfaction
                Conducted workshops and seminars on dental health awareness
                Published articles in Dental Journals And Magazines on cosmetic and restorative dentistry<br><br>

                <span style="color: red; font-size: 18px;">Personal Philosophy:</span><br>
                Dr. Perrin believes in combining artistry with science to create healthy, confident smiles. She is passionate about educating patients on maintaining long-term oral health while providing treatments that enhance both aesthetics and functionality.
            </p>
        </div>
        <div class="tab-content" id="gallery">
            <p>Gallery content here...</p>
        </div>
        <div class="tab-content" id="reviews">
            <div class="rating-summary-box">
                <div class="average-score">
                    <h1 id="averageNumber">0.0</h1>
                    <div id="averageStars"></div>
                    <p id="totalReviews">0 Reviews</p>
                </div>
                <div class="rating-breakdown" id="ratingBreakdown"></div>
            </div>
            <div class="add-review">
                <h4>Add Your Review</h4>
                <div class="star-select">
                    <i class="fa fa-star" data-rate="1"></i>
                    <i class="fa fa-star" data-rate="2"></i>
                    <i class="fa fa-star" data-rate="3"></i>
                    <i class="fa fa-star" data-rate="4"></i>
                    <i class="fa fa-star" data-rate="5"></i>
                </div>
                <input type="text" id="reviewName" placeholder="Your Name">
                <textarea id="reviewComment" placeholder="Write your comment"></textarea>
                <button id="submitReview" class="primary">Submit Review</button>
            </div>
            <div id="reviewsList"></div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="{{ asset('Java/DentistDetail.js') }}"></script>
</body>

</html>