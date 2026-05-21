<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'diagnosis',
        'prescription',
        'amount'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}