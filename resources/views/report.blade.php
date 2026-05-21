<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Order Received</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('normalize.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('CSS/report.css') }}" />
</head>

<body>
    <nav class="navbar navbar-expand-lg position-sticky top-0 navbar-custom">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand right-0 navbar-toggler border-0" href="{{ url('/') }}">
                <img src="{{ asset('images/Logo1 Update.png') }}" alt="" width="150px" />
            </a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/Logo1 Update.png') }}" alt="" width="150px" />
                </a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 item">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/About') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/Services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/Doctors') }}">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/Consultations') }}">Consultations</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contactUs') }}">Contact Us</a></li>
                </ul>
                <ul class="navbar-nav ms-auto spe profile-icon" id="profileIcon">
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg me-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end ms-5" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="{{ url('/Profile') }}"><i class="fas fa-user-circle fa-lg me-1"></i> Account</a></li>
                            <li><a class="dropdown-item text-danger" href="{{ url('/logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Log-out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <p class="success-text">
            <i class="fa-solid fa-circle-check"></i>
            Thank you. Your order has been received.
        </p>

        @if($payment)
        <div class="order-info">
            {{-- السطر 85 -- ORDER NUMBER --}}
            <div>
                <span>ORDER NUMBER</span>
                <strong>{{ $payment->id }}</strong>
            </div>
            {{-- السطر 90 -- DATE --}}
            <div>
                <span>DATE</span>
                <strong>{{ $payment->created_at->format('d M Y') }}</strong>
            </div>
            {{-- السطر 95 -- EMAIL --}}
            <div>
                <span>EMAIL</span>
                <strong>{{ $payment->email }}</strong>
            </div>
            {{-- السطر 100 -- TOTAL --}}
            <div>
                <span style="margin-left: 50px;">TOTAL</span>
                <strong style="margin-left: 50px;">${{ $payment->amount }}</strong>
            </div>
            {{-- السطر 105 -- PAYMENT METHOD --}}
            <div>
                <span>PAYMENT METHOD</span>
                <strong>{{ $payment->payment_method }}</strong>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Doctor Booking (×1)</h3>
                <button class="print-btn" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> PRINT
                </button>
            </div>
            <div class="card-body">
                <div class="row"><span>Consultation fee</span><span>${{ $payment->amount }}</span></div>
                <div class="row"><span>Total amount</span><span>${{ $payment->amount }}</span></div>
                <div class="row"><span>Appointment time</span><span>{{ $payment->appointment->time }}</span></div>
                <div class="row"><span>Appointment date</span><span>{{ $payment->appointment->date }}</span></div>
                <div class="row"><span>Name</span><span>{{ $payment->first_name }} {{ $payment->last_name }}</span></div>
                <div class="row"><span>Email address</span><span>{{ $payment->email }}</span></div>
                <div class="row"><span>City</span><span>{{ $payment->city }}</span></div>
                <div class="row"><span>Address</span><span>{{ $payment->address }}</span></div>
            </div>
        </div>
        @else
        <p class="text-danger">No payment data found.</p>
        @endif

        <a href="{{ url('/home') }}" style="text-decoration: none;">
            <button class="back-btn">Return to Home</button>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('Java/report.js') }}"></script>
</body>

</html>