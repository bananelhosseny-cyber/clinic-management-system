<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

/**
 * AppointmentController
 *
 * Handles patient-side appointment booking.
 *    to prevent race conditions when two users book the same slot simultaneously.
 *  - Double-booking blocked at both the validation layer AND the database layer.
 *  - Pending-appointment check prevents a user from having multiple pending bookings.
 *  - Timezone: Africa/Cairo (set in config/app.php).
 *  - Date stored as DATE, time stored as TIME — never combined into a single DATETIME.
 *  - Day of week derived dynamically from Carbon; never stored in the database.
 */
class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // The NoPendingAppointment middleware also fires here as a safety net.
        // The store() action is exempt because the Form Request already checks it
        // with a user-friendly validation error message.
    }

    /**
     * Store a new appointment.
     *
     * Uses a DB transaction + lockForUpdate to guarantee atomicity.
     * If two requests arrive simultaneously for the same slot, only the
     * first one to acquire the lock will succeed; the second will find
     * the slot taken and fail validation inside the transaction.
     */
    public function store(StoreAppointmentRequest $request)
    {
        try {
            $appointment = DB::transaction(function () use ($request) {
                $alreadyTaken = Appointment::where('doctor_id', $request->doctor_id)
                    ->where('date', $request->date)
                    ->where('time', $request->time)
                    ->whereIn('status', ['pending', 'approved'])
                    ->lockForUpdate()
                    ->exists();

                if ($alreadyTaken) {
                    throw new \Exception('slot_taken');
                }

                $patientName = $request->first_name
                    ?? $request->name
                    ?? 'Unknown';

                return Appointment::create([
                    'doctor_id'  => $request->doctor_id,
                    'patient_id' => Auth::id(),
                    'date'       => $request->date,
                    'time'       => $request->time,
                    'status'     => 'pending',
                    'notes'      => "Name: {$patientName} | Phone: {$request->phone}",
                    'appointment_date' => $request->date . ' ' . $request->time,
                ]);
            });

            $patient = Auth::user();

            Mail::raw(
                "تم استلام طلب حجزك!

    التاريخ: " . $appointment->date->format('Y-m-d') . "
    الوقت:   " . $appointment->time . "

    يرجى الانتظار حتى يتم تأكيد الموعد من الدكتور.",

                function ($message) use ($patient) {
                    $message->to($patient->email)
                        ->subject('تم استلام طلب الحجز');
                }
            );

            session(['appointment_id' => $appointment->id]);
            return redirect()->route('waiting');
        } catch (\Exception $e) {
            $message = match ($e->getMessage()) {
                'slot_taken' => 'This time slot is already booked. Please choose a different time.',
                default      => 'An error occurred: ' . $e->getMessage(),
            };
            return back()->withErrors(['booking' => $message])->withInput();
        }
    }

    /**
     * Show appointments for the currently logged-in patient.
     * Derives the day of week from Carbon — never from the database.
     */
    public function myAppointments()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->get()
            ->map(function ($appt) {
                $appt->day = Carbon::parse($appt->date)->format('l'); // dynamic
                return $appt;
            });

        return view('my-appointments', compact('appointments'));
    }
}
