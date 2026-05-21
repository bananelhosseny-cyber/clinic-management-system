<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // بيعرض صفحة الـ Checkout
    public function index()
    {
        $appointment = Appointment::find(session('appointment_id'));
        return view('checkout', compact('appointment'));
    }

    // بيحفظ الدفع في الـ DB
    public function store(Request $request)
    {
        $payment = Payment::create([
            'appointment_id' => session('appointment_id'),
            'patient_id'     => Auth::id(),
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'          => $request->email,
            'city'           => $request->city,
            'address'        => $request->address,
            'payment_method' => $request->payment,
            'amount'         => 200.00,
        ]);

        session(['payment_id' => $payment->id]);
        return redirect()->route('report');
    }

    // بيعرض صفحة الـ Report
    public function report()
    {
        $payment = Payment::with('appointment')
            ->find(session('payment_id'));

        return view('report', compact('payment'));
    }
}
