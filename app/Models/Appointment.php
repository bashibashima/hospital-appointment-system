<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    /**
     * Relationship: Appointment belongs to a Doctor (User)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Relationship: Appointment belongs to a Patient (User)
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
    // In App\Models\Appointment.php
}


