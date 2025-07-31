<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];



// For basic info like doctor name/email from users table

    public function doctor()
{
    return $this->belongsTo(User::class, 'doctor_id');
}

// For extra info like specialization, bio from doctors table
public function doctorProfile()
{
    return $this->hasOne(Doctor::class, 'user_id', 'doctor_id');
}

public function patient()
{
    return $this->belongsTo(User::class, 'patient_id');
}
}

