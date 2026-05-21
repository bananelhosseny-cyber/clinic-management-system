<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

/**
 * DoctorApiController
 *
 * REST API consumed by the Doctor Dashboard (JavaScript SPA).
 *
 * Status enum values (aligned with DB ENUM):
 *   pending  → awaiting doctor action
 *   approved → doctor approved
 *   cancelled→ doctor rejected / cancelled
 *
 * NOTE: Old statuses "confirm", "complete", "cancel" are REMOVED.
 * The migration converts legacy records. The JS dashboard must use
 * the new values ("approved", "cancelled") as updated in the JS files.
 */
class DoctorApiController extends Controller
{
    // ── Auth ──────────────────────────────────────────────────────────────────

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($user->user_type !== 'doctor') {
            return response()->json(['message' => 'Only doctors can log in here'], 403);
        }

        // Revoke previous tokens to avoid accumulation (each login = fresh token)
        $user->tokens()->delete();

        $token = $user->createToken('doctorToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token'  => $token,
            'doctor' => [
                'id'         => $user->id,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'email'      => $user->email,
                'user_type'  => $user->user_type,
            ],
        ]);
    }

    // ── Appointments ──────────────────────────────────────────────────────────

    /**
     * GET /api/appointments
     * Returns all appointments for the authenticated doctor.
     * Day of week is derived from Carbon here — never stored in the DB.
     */
    public function getAppointments()
    {
        $doctorId = Auth::id();

        $appointments = Appointment::where('doctor_id', $doctorId)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get()
            ->map(function ($appt) {
                // جيب اسم المريض من الـ notes
                $patientName = 'Unknown';
                $patientPhone = '—';

                if ($appt->notes) {
                    if (str_contains($appt->notes, 'Name:')) {
                        $parts = explode(' | ', $appt->notes);
                        foreach ($parts as $part) {
                            if (str_starts_with($part, 'Name:')) {
                                $patientName = trim(str_replace('Name:', '', $part));
                            }
                            if (str_starts_with($part, 'Phone:')) {
                                $patientPhone = trim(str_replace('Phone:', '', $part));
                            }
                        }
                    }
                }

                return [
                    'id'             => $appt->id,
                    'date'           => $appt->date->format('Y-m-d'),
                    'day'            => Carbon::parse($appt->date)->format('l'),
                    'time'           => $appt->time,
                    'time_formatted' => Carbon::createFromTimeString($appt->time)->format('g:i A'),
                    'status'         => $appt->status,
                    'notes'          => $appt->notes,
                    'patient'        => [
                        'id'         => $appt->patient_id,
                        'first_name' => $patientName,
                        'last_name'  => '',
                        'phone'      => $patientPhone,
                        'email'      => '',
                    ],
                ];
            });

        return response()->json([
            'status' => 'success',
            'data'   => $appointments,
        ]);
    }


    /**
     * POST /api/appointment-status
     * Doctor approves or cancels an appointment.
     *
     * Accepted status values: "approved" | "cancelled"
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id'      => 'required|exists:appointments,id',
            'status' => 'required|in:approved,cancelled,completed',
            'message' => 'nullable|string|max:500',
        ]);

        $appointment = Appointment::where('id', $request->id)
            ->where('doctor_id', Auth::id())
            ->firstOrFail();

        $appointment->status = $request->status;

        // Append doctor message to notes field (no separate table needed)
        if ($request->filled('message')) {
            // Avoid duplicating the DoctorMsg section
            $base = preg_replace('/ \| DoctorMsg:.*$/s', '', $appointment->notes ?? '');
            $appointment->notes = $base . ' | DoctorMsg: ' . $request->message;
        }

        $appointment->save();
        try {
            $patient = $appointment->patient;

            if ($request->status === 'approved') {
                Mail::raw(
                    "تم تأكيد موعدك!

                التاريخ: " . $appointment->date->format('Y-m-d') . "
                الوقت:   " . $appointment->time . "

                نراكم قريباً 😊",
                    function ($message) use ($patient) {
                        $message->to($patient->email)
                            ->subject('تم تأكيد موعدك ✅');
                    }
                );
            } elseif ($request->status === 'cancelled') {
                Mail::raw(
                    "نأسف، تم إلغاء موعدك.

                التاريخ: " . $appointment->date->format('Y-m-d') . "
                الوقت:   " . $appointment->time . "

                يمكنك حجز موعد جديد في أي وقت.",
                    function ($message) use ($patient) {
                        $message->to($patient->email)
                            ->subject('تم إلغاء موعدك ❌');
                    }
                );
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the API response
            \Log::error('Mail Error: ' . $e->getMessage());
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Appointment status updated to ' . $request->status,
        ]);
    }

    /**
     * GET /api/appointment-status/{id}
     * Patient waiting page polls this to get real-time status updates.
     * No auth required — patient only has the ID from their session.
     */
    public function checkStatus($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['status' => 'error', 'message' => 'Appointment not found'], 404);
        }

        // Extract doctor message from notes
        $doctorMessage = null;
        if ($appointment->notes && str_contains($appointment->notes, 'DoctorMsg:')) {
            $parts         = explode(' | DoctorMsg: ', $appointment->notes);
            $doctorMessage = $parts[1] ?? null;
        }

        return response()->json([
            'status'         => 'success',
            'appt_status'    => $appointment->status,      // "pending" | "approved" | "cancelled"
            'doctor_message' => $doctorMessage,
            'date'           => $appointment->date?->format('Y-m-d'),
            'time'           => $appointment->time,
        ]);
    }

    // ── Profile ───────────────────────────────────────────────────────────────

    public function getProfile()
    {
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'data'   => [
                'id'         => $user->id,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'email'      => $user->email,
            ],
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'first_name' => 'sometimes|string|max:100',
            'last_name'  => 'sometimes|string|max:100',
            'email'      => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        $user->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Profile updated successfully',
            'data'    => $user,
        ]);
    }

    /**
     * GET /api/available-slots?doctor_id=X&date=Y-m-d
     *
     * Returns which time slots are still available for a given doctor and date.
     * The frontend should call this when the user picks a date on the calendar,
     * REPLACING the current static mock array in BookingCardiology.js.
     */
    public function availableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|integer|exists:users,id',
            'date'      => 'required|date_format:Y-m-d',
        ]);

        // All possible slots (30-minute intervals, 9 AM – 4 PM)
        $allSlots = [
            '09:00',
            '09:35',
            '10:10',
            '10:45',
            '11:20',
            '11:55',
            '12:30',
            '13:05',
            '13:40',
            '14:15',
            '14:50',
            '15:25',
        ];

        // Find already-booked slots for this doctor+date (only pending/approved)
        $booked = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $request->date)
            ->whereIn('status', ['pending', 'approved'])
            ->pluck('time')
            ->map(fn($t) => substr($t, 0, 5)) // strip seconds
            ->toArray();

        $available = array_filter($allSlots, fn($slot) => !in_array($slot, $booked));

        return response()->json([
            'status' => 'success',
            'date'   => $request->date,
            'slots'  => array_values($available),
        ]);
    }
    public function getTodayAppointments()
    {
        $doctorId = Auth::id();

        $today = Carbon::now()->toDateString();

        $appointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->whereDate('date', '=', $today)
            ->orderBy('time', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'today'  => $today,
            'count'  => $appointments->count(),
            'data'   => $appointments,
            'doctorId' => Auth::id(),
        ]);
    }
}
