{{--
    appointment.blade.php

    CHANGES:
    - Removed reliance on localStorage for date/time (appointment.js now reads hidden fields)
    - Added hidden fields: selected_date and selected_time
    - Added validation error display
    - form id="appointmentForm" for JS hook
    - Field names: date + time (matching controller)
--}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Info</title>
    <link rel="stylesheet" href="{{ asset('CSS/appointment.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/normalize.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>

<body>

    <nav class="navbar navbar-expand-lg position-sticky top-0 navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="{{ asset('images/Logo1 Update.png') }}" alt="" width="150px" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/doctors') }}">Doctors</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger" href="{{ url('/logout') }}">
                                    <i class="fa-solid fa-right-from-bracket"></i> Log-out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Validation errors --}}
    @if ($errors->any())
    <div class="alert alert-danger mx-4 mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="page-wrapper">
        <div class="doctor-card">
            <div class="doctor-image">
                <img src="{{ asset('images/' . $doctor['image']) }}" alt="Doctor Image">
            </div>
            <div class="doctor-info">
                <h2 class="doctor-name">Dr. {{ $doctor['name'] }}</h2>
                <p class="doctor-specialty">{{ $doctor['specialty'] }}</p>
                <div class="doctor-location">
                    <span class="location-icon">{{ $doctor['location'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{--
        Hidden fields receive values from the booking calendar JS
        (BookingCardiology.js sets these before form submission,
        replacing the old localStorage approach).
    --}}
    <form action="{{ route('appointment.store') }}" method="POST" id="appointmentForm">
        @csrf
        <input type="hidden" name="doctor_id" value="{{ $doctor['id'] }}">
        <input type="hidden" name="date" id="selected_date"
            value="{{ old('date', session('booking_date')) }}">
        <input type="hidden" name="time" id="selected_time"
            value="{{ old('time', session('booking_time')) }}">

        <div class="patient-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="patientSelect">Select Patient</label>
                    <select id="patientSelect" name="patient_type" class="form-control">
                        <option value="myself">My Self</option>
                        <option value="someone_else">Someone Else</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input required type="text" name="first_name" id="firstName"
                        class="form-control" placeholder="First name"
                        value="{{ old('first_name') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input required type="text" name="phone" id="phoneNumber"
                        class="form-control" placeholder="01xxxxxxxxx"
                        value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    <label for="emailAddress">Email Address</label>
                    <input required type="email" name="email" id="emailAddress"
                        class="form-control" placeholder="patient@example.com"
                        value="{{ old('email') }}">
                </div>
            </div>
        </div>

        <div class="page-actions">
            <button type="button" class="btn-back" onclick="window.history.back()">Back</button>
            <button type="submit" class="btn-primary" id="selectPaymentBtn">
                Confirm Booking
            </button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const dateVal = urlParams.get('date');
        const timeVal = urlParams.get('time');
        if (dateVal) document.getElementById('selected_date').value = dateVal;
        if (timeVal) document.getElementById('selected_time').value = timeVal;
    </script>
    <script src="{{ asset('Java/appointment.js') }}"></script>
</body>
</body>

</html>