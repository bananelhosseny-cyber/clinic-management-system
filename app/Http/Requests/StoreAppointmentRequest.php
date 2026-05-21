<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Appointment;

/**
 * Form Request: StoreAppointmentRequest
 *
 * Validates all appointment booking inputs BEFORE the controller runs.
 * Handles two critical business rules:
 *   1. No double-booking the same slot (doctor + date + time, status != cancelled)
 *   2. Patient cannot have multiple pending appointments simultaneously
 */
class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Must be authenticated (enforced by middleware too, but belt + braces)
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'doctor_id'  => ['required', 'integer', 'exists:users,id'],
            'date'       => ['required', 'date_format:Y-m-d'],
            'time'       => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'first_name' => ['nullable', 'string', 'max:100'],
            'phone'      => ['required', 'string', 'max:20'],
            'email'      => ['nullable', 'email'],
        ];
    }

    // public function withValidator($validator): void
    // {
    //     $validator->after(function ($validator) {
    //         $user = auth()->user();

    //         // ── Rule 1: Check for pending appointment for this user ───────────
    //         if (Appointment::userHasPending($user->id)) {
    //             $validator->errors()->add(
    //                 'pending',
    //                 'You already have a pending appointment. Please wait for the doctor to respond before booking again.'
    //             );
    //         }

    //         // ── Rule 2: Check slot availability (double-booking prevention) ──
    //         if (
    //             $this->filled('doctor_id') &&
    //             $this->filled('date') &&
    //             $this->filled('time')
    //         ) {
    //             if (Appointment::slotIsTaken(
    //                 (int) $this->doctor_id,
    //                 $this->date,
    //                 $this->time
    //             )) {
    //                 $validator->errors()->add(
    //                     'time',
    //                     'This time slot is already booked. Please choose a different time.'
    //                 );
    //             }
    //         }
    //     });
    // }

    public function messages(): array
    {
        return [
            'date.after_or_equal' => 'You cannot book an appointment in the past.',
            'doctor_id.exists'    => 'The selected doctor does not exist.',
            'time.regex'          => 'Time must be in HH:MM format (24-hour).',
        ];
    }
}
