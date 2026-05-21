<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;

// ══════════════════════════════
// AUTH
// ══════════════════════════════
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

// Password Reset
Route::get('/verification',  [AuthController::class, 'showVerificationForm'])->name('verification.form');
Route::post('/verification', [AuthController::class, 'sendVerificationCode'])->name('verification.send');
Route::get('/reset-password',  [AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/new-password',   [AuthController::class, 'storeNewPassword'])->name('password.store');

// ══════════════════════════════
// PUBLIC PAGES
// ══════════════════════════════
Route::get('/', fn() => view('home'))->name('home');
Route::get('/home', fn() => view('home'));
Route::post('/home', fn() => view('home'));

Route::get('/about',         [PageController::class, 'about'])->name('about');
Route::get('/services',      [PageController::class, 'services'])->name('services');
Route::get('/contact',       [PageController::class, 'contact'])->name('contact');
Route::get('/consultations', fn() => view('consultations'))->name('consultations');
Route::get('/doctors',       [DoctorController::class, 'index'])->name('doctors');
Route::get('/doctor/{id}',   [DoctorController::class, 'show'])->name('doctor.show');

// Doctor Details Pages
Route::get('/details/dentist',     fn() => view('DentistDetail'))->name('dentist.detail');
Route::get('/details/orthopedics', fn() => view('OrthopedicsDetails'));
Route::get('/details/cardiology',  fn() => view('CardiologyDetails'));

// ══════════════════════════════════════════════════════════════
// PROTECTED — require login
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth'])->group(function () {

    // ── Waiting page (always accessible to check status) ─────────────────────
    Route::get('/waiting', fn() => view('waiting'))->name('waiting');

    // ── My appointments ───────────────────────────────────────────────────────
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])
        ->name('my-appointments');

    // ── Booking flow ─ protected by 'no.pending' middleware ──────────────────
    // The middleware will redirect to /waiting if the user already has a pending booking.
    Route::get('/cardiology',   [BookingController::class, 'cardiology'])->name('cardiology');
    Route::get('/dentist',      [BookingController::class, 'dentist'])->name('dentist');
    Route::get('/orthopedics',  [BookingController::class, 'orthopedics'])->name('orthopedics');
    Route::get('/appointment/{doctor_id}', [BookingController::class, 'create'])->name('appointment.create');

    // ── Appointment store (not behind no.pending — Form Request handles that) ─
    Route::middleware(['no.pending'])->group(function () {
        Route::post('/appointment/store', [AppointmentController::class, 'store'])->name('appointment.store');
        Route::post('/appointment/save',  [AppointmentController::class, 'store'])->name('appointment.save');
    });
    // ── Doctor Dashboards ─────────────────────────────────────────────────────
    Route::get('/cardiology-dashboard', fn() => view('cardiology-dashboard'));
    Route::get('/dentist-dashboard',    fn() => view('dentist-dashboard'));
    Route::get('/ortho-dashboard',      fn() => view('ortho-dashboard'));

    Route::get('/checkout',          [CheckoutController::class, 'index'])->name('checkout.show');
    Route::post('/checkout/process', [CheckoutController::class, 'store'])->name('checkout.process');
    Route::get('/report',            [CheckoutController::class, 'report'])->name('report');
});

// Route::middleware(['auth'])->group(function () {

//     // ── Waiting page (always accessible to check status) ─────────────────────
//     Route::get('/waiting', fn() => view('waiting'))->name('waiting');

//     // ── My appointments ───────────────────────────────────────────────────────
//     Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])
//         ->name('my-appointments');
//     Route::get('/cardiology',   [BookingController::class, 'cardiology'])->name('cardiology');
//     Route::get('/dentist',      [BookingController::class, 'dentist'])->name('dentist');
//     Route::get('/orthopedics',  [BookingController::class, 'orthopedics'])->name('orthopedics');
//     Route::get('/appointment/{doctor_id}', [BookingController::class, 'create'])->name('appointment.create');

//     // ── Booking flow ─ protected by 'no.pending' middleware ──────────────────
//     // The middleware will redirect to /waiting if the user already has a pending booking.
//     Route::middleware(['no.pending'])->group(function () {
//         Route::post('/appointment/store', [AppointmentController::class, 'store'])->name('appointment.store');
//         Route::post('/appointment/save',  [AppointmentController::class, 'store'])->name('appointment.save');
//     });

//     // ── Checkout ──────────────────────────────────────────────────────────────


//     Route::get('/cardiology-dashboard', function () {
//         $user = auth::user();
//         $user->tokens()->where('name', 'doctorToken')->delete();
//         $token = $user->createToken('doctorToken')->plainTextToken;
//         return view('cardiology-dashboard', ['apiToken' => $token]);
//     });

//     Route::get('/dentist-dashboard', function () {
//         $user = auth::user();
//         $user->tokens()->where('name', 'doctorToken')->delete();
//         $token = $user->createToken('doctorToken')->plainTextToken;
//         return view('dentist-dashboard', ['apiToken' => $token]);
//     });

//     Route::get('/ortho-dashboard', function () {
//         $user = auth::user();
//         $user->tokens()->where('name', 'doctorToken')->delete();
//         $token = $user->createToken('doctorToken')->plainTextToken;
//         return view('ortho-dashboard', ['apiToken' => $token]);
//     });
// });
Route::get('/test-patients', function () {
    $patients = \App\Models\Patient::all();
    return response()->json([
        'count' => $patients->count(),
        'data'  => $patients
    ]);
});
Route::post('/contact-send', [\App\Http\Controllers\ContactController::class, 'store']);
Route::post('/contact/store', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
// Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);
