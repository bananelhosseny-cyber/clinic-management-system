<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Doctor Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('normalize.css') }}" />
    <link rel="stylesheet" href="{{ asset('CSS/BookingDen.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>

    <nav class="navbar navbar-expand-lg position-sticky top-0 navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand right-0 navbar-toggler border-0" href="#"><img src="{{ asset('images/Logo1 Update.png') }}" alt="" width="150px" /></a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#"><img src="{{ asset('images/Logo1 Update.png') }}" alt="" width="150px" /></a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 item">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/doctors') }}">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Consultations</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
                <ul class="navbar-nav ms-auto spe profile-icon" id="profileIcon">
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg me-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end ms-5" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle fa-lg me-1"></i> Account</a></li>
                            <li><a class="dropdown-item text-danger" href="{{ url('/logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Log-out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Hidden form: الـ JS هيملي selected_date و selected_time ويعمل submit --}}
    <form id="bookingForm" action="{{ url('/appointment/1') }}" method="GET" style="display:none;">
        <input type="hidden" id="selected_date" name="date">
        <input type="hidden" id="selected_time" name="time">
    </form>

    <div class="booking-page">
        <div class="doctor-card">
            <div class="doctor-main-info">
                <img src="{{ asset('images/Dentist Doc.jpg') }}" class="doctor-avatar" alt="Doctor">
                <div class="doctor-text">
                    <h2 class="doctor-name">Dr. Ruby Perrin</h2>
                    <span class="doctor-specialty">Dentist</span>
                    <p class="doctor-location">Scottsdale, Arizona, United States, 20005</p>
                </div>
            </div>
            <div class="booking-info">
                <h4>Booking Info.</h4>
                <p>Media Carely</p>
            </div>
        </div>

        <div class="booking-box">
            <div class="calendar-box">
                <div class="calendar-header">
                    <button id="prevMonth" class="calendar-nav">‹</button>
                    <h3 id="monthTitle"></h3>
                    <button id="nextMonth" class="calendar-nav">›</button>
                </div>
                <div class="calendar-weekdays">
                    <div>Su</div>
                    <div>Mo</div>
                    <div>Tu</div>
                    <div>We</div>
                    <div>Th</div>
                    <div>Fr</div>
                    <div>Sa</div>
                </div>
                <div id="calendarDates" class="calendar-days"></div>
            </div>
            <div class="slots-box" id="slotsBox">
                <div class="empty-slots">
                    Please select a date to see available time slots.
                </div>
            </div>
        </div>

        <div class="booking-footer">
            <button class="btn-back" onclick="window.history.back()">Back</button>
            <button class="btn-next" id="nextBtn">Add Basic Information</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    {{-- الـ JS بتاعنا هو اللي بيتحكم في nextBtn — مش محتاج script تاني هنا --}}
    <script src="{{ asset('Java/BookingDen.js') }}"></script>

</body>

</html>