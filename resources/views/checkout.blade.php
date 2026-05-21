<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('normalize.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('CSS/Checkout.css') }}" />
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
                    <li class="nav-item dropdown me-5">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg me-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end ms-5" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="Profile.html">
                                    <i class="fas fa-user-circle fa-lg me-1"></i> Account</a>
                            </li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                    <i class="fa-solid fa-right-from-bracket"></i> Log-out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="checkout-container">
        <section class="billing">
            <h2>Billing details</h2>
            <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="row">
                    <div>
                        <label>First name <span id="star">*</span></label>
                        <input type="text" name="first_name" value="{{ request('first_name') }}" placeholder="Enter Your First Name" required />
                    </div>
                    <div>
                        <label>Last name <span id="star">*</span></label>
                        <input type="text" name="last_name" placeholder="Enter Your Last Name" required />
                    </div>
                </div>
                <label>Email Address <span id="star">*</span></label>
                <input type="email" name="email" value="{{ request('email') }}" placeholder="Enter Your Email" required />

                <label>Company name (optional)</label>
                <input type="text" name="company" />

                <label>Town / City<span id="star">*</span></label>
                <input type="text" name="city" placeholder="Enter Town or City" required />

                <label>Street address <span id="star">*</span></label>
                <input type="text" name="address" placeholder="Enter Street Address" required />
        </section>
        <aside class="order">
            <h2>Your order</h2>
            <div class="order-box">
                <div class="order-row head">
                    <span>Product</span>
                    <span>Subtotal</span>
                </div>
                <div class="order-row">
                    <span>Doctor Booking × 1</span>
                    <span>$200.00</span>
                </div>
                <div class="order-row total">
                    <span>Total</span>
                    <span>$200.00</span>
                </div>
            </div>
            <div class="payment">
                <h3>Payment Methods</h3>
                <label class="radio">
                    <input type="radio" name="payment" value="bank" checked />
                    Direct bank transfer
                </label>
                <p class="desc">
                    Make your payment directly into our bank account. Please use your
                    Order ID as the payment reference.
                </p>
                <label class="radio">
                    <input type="radio" name="payment" value="check" />
                    Check payments
                </label>
                <label class="radio">
                    <input type="radio" name="payment" value="cash" />
                    Cash on delivery
                </label>
                <label class="radio">
                    <input type="radio" name="payment" value="paypal" />PayPal
                </label>
                <div class="page-actions">
                    <button type="submit" class="btn-primary" onclick="return confirm('Are you sure you want to place this order?')">PLACE ORDER</button>
                    <button type="button" class="btn-back" onclick="window.history.back()">Back</button>
        </aside>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('JavaScript/Checkout.js') }}"></script>
</body>

</html>

</html>