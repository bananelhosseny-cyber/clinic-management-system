<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Info - Orthopedics</title>

    <link rel="stylesheet" href="{{ asset('css/appointment.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/doctors') }}">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/consultations') }}">Consultations</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>

                <ul class="navbar-nav ms-auto spe profile-icon" id="profileIcon">
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg me-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end ms-5" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="fas fa-user-circle fa-lg me-1"></i> Account</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
                                    @csrf
                                </form>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket"></i> Log-out
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-wrapper">
        <div class="doctor-card">
            <div class="doctor-image">
                <img src="{{ asset('images/Orthopedics Doc.jpg') }}" alt="Doctor Image">
            </div>
            <div class="doctor-info">
                <h2 class="doctor-name">Dr. Mahmoud Ahmed</h2>
                <p class="doctor-specialty">Orthopedic Surgeon</p>
                <div class="doctor-location">
                    <span class="location-icon">Scottsdale, Arizona, United States</span>
                </div>
            </div>
        </div>

        <form action="{{ url('/appointment/store') }}" method="POST">
            @csrf
            <input type="hidden" name="doctor_id" value="8">
            <div class="patient-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="patientSelect">Select Patient</label>
                        <select id="patientSelect" name="patient_relation" class="form-control">
                            <option value="myself">My Self</option>
                            <option value="someone_else">Someone Else</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="firstName">Full Name</label>
                        <input required type="text" name="name" id="firstName" class="form-control" placeholder="Emily Rival">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input required type="number" name="phone" id="phoneNumber" class="form-control" placeholder="Must Be 11 Digits Only">
                    </div>
                    <div class="form-group">
                        <label for="emailAddress">Email Address</label>
                        <input required type="email" name="email" id="emailAddress" class="form-control" placeholder="patient@example.com">
                    </div>
                </div>
            </div>

            <div class="page-actions">
                <button type="button" class="btn-back" onclick="window.history.back()">Back</button>
                <button type="submit" class="btn-primary" id="selectPaymentBtn">
                    Select Payment
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/appointment.js') }}"></script>
</body>

</html>