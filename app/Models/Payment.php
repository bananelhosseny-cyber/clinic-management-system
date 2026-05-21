<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'appointment_id', 'patient_id',
        'first_name', 'last_name',
        'email', 'city', 'address',
        'payment_method', 'amount',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
