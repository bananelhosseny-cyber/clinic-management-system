<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'time',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Derive the day name dynamically from the stored date.
     * Never stored in DB — always computed from Carbon.
     */
    public function getDayAttribute(): string
    {
        return Carbon::parse($this->date)->format('l'); // e.g. "Monday"
    }

    /**
     * Return time formatted as 12-hour with am/pm for display.
     */
    public function getTimeFormattedAttribute(): string
    {
        return Carbon::createFromTimeString($this->time)->format('g:i A');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'approved']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForDoctor($query, int $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Check whether a slot is already taken for the given doctor+date+time.
     * A slot is blocked when an appointment is pending OR approved.
     */
    public static function slotIsTaken(int $doctorId, string $date, string $time, ?int $excludeId = null): bool
    {
        return self::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('time', $time)
            ->whereIn('status', ['pending', 'approved'])
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->lockForUpdate()
            ->exists();
    }

    /**
     * Check whether the given user already has a pending appointment.
     */
    public static function userHasPending(int $userId): bool
    {
        return self::where('patient_id', $userId)
            ->where('status', 'pending')
            ->exists();
    }
}
