<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * BookingController
 *
 * Handles the booking flow: specialty selection → calendar → appointment form.
 *
 * CHANGES:
 *  - create() now reads date+time from query string (passed by booking JS)
 *    instead of relying on localStorage (which was client-only and fragile)
 *  - Doctor IDs now use the real user IDs from the users table
 *    (doctor records: 7=John Smith/Cardiology, 8=Mahmoud/Ortho, 9=Ruby/Dentist)
 *  - processCheckout() is a placeholder; real booking goes through AppointmentController
 */
class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cardiology()
    {
        return view('BookingCardiology');
    }

    public function dentist()
    {
        return view('BookingDen');
    }

    public function orthopedics()
    {
        return view('BookingOrthopedics');
    }

    /**
     * Show the appointment info/confirmation form for a given doctor slot.
     *
     * Date and time come from the query string (set by the booking calendar JS).
     * If not present (e.g., user navigated directly), redirect back to selection.
     */
    public function create(Request $request, $doctor_id)
    {
        /**
         * Doctor map: key = URL param, value = doctor info.
         *
         * 'id' is the REAL user_id from the users table (used as doctor_id in appointments).
         * The URL param (1/2/3) is just a UI routing handle.
         */
        $doctors = [
            '1' => [
                'id'        => '9',               // Ruby Perrin (user_id = 9)
                'name'      => 'Ruby Perrin',
                'specialty' => 'Dentist',
                'image'     => 'Dentist Doc.jpg',
                'location'  => 'Scottsdale, Arizona, United States',
            ],
            '2' => [
                'id'        => '7',               // John Smith (user_id = 7)
                'name'      => 'John Smith',
                'specialty' => 'Cardiologist',
                'image'     => 'cardiology Doc.jpg',
                'location'  => 'New York, USA',
            ],
            '3' => [
                'id'        => '8',               // Mahmoud Ahmed (user_id = 8)
                'name'      => 'Mahmoud Ahmed',
                'specialty' => 'Orthopedic Surgeon',
                'image'     => 'Orthopedics Doc.jpg',
                'location'  => 'Cairo, Egypt',
            ],
        ];

        if (!array_key_exists($doctor_id, $doctors)) {
            return redirect()->route('doctors')->with('error', 'Doctor not found.');
        }

        $doctor = $doctors[$doctor_id];

        // Date and time passed from the booking calendar JS via query string
        $selectedDate = $request->query('date');
        $selectedTime = $request->query('time');
        session(['booking_date' => $selectedDate, 'booking_time' => $selectedTime]);

        if (!$selectedDate || !$selectedTime) {
            // User didn't go through the calendar — send them back
            return redirect()->back()->with('error', 'Please select a date and time slot first.');
        }

        return view('appointment', compact('doctor', 'doctor_id', 'selectedDate', 'selectedTime'));
    }

    public function showCheckout()
    {
        return view('checkout');
    }

    public function processCheckout(Request $request)
    {
        // Checkout is handled separately; this redirects to the report page.
        return redirect()->route('report');
    }
}
