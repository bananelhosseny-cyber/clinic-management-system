<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: NoPendingAppointment
 *
 * Prevents a logged-in patient from accessing the booking flow
 * if they already have a PENDING appointment.
 *
 * Attach to booking routes:
 *   Route::middleware(['auth', 'no.pending'])->group(...)
 *
 * Registration in bootstrap/app.php (Laravel 11):
 *   ->withMiddleware(function (Middleware $middleware) {
 *       $middleware->alias(['no.pending' => NoPendingAppointment::class]);
 *   })
 *
 * OR in app/Http/Kernel.php (Laravel 10):
 *   protected $routeMiddleware = [
 *       'no.pending' => \App\Http\Middleware\NoPendingAppointment::class,
 *   ];
 */
class NoPendingAppointment
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only applies to authenticated patients
        $user = $request->user();
        if (!$user) {
            return $next($request);
        }

        // Doctors skip this check entirely
        if ($user->user_type === 'doctor') {
            return $next($request);
        }

        // Check if this patient already has a pending appointment
        $hasPending = Appointment::where('patient_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            // Restore the session appointment_id so the waiting page can poll correctly
            if (!session()->has('appointment_id')) {
                $pendingAppt = Appointment::where('patient_id', $user->id)
                    ->where('status', 'pending')
                    ->latest()
                    ->value('id');
                session(['appointment_id' => $pendingAppt]);
            }

            return redirect()->route('waiting')
                ->with('info', 'You already have a pending appointment. Please wait for the doctor to respond.');
        }

        return $next($request);
    }
}
