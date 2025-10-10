<?php
namespace App\Models;
use App\Models\Appointment;
use App\Models\Notification;

use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */



protected $fillable = [
    'name',
    'email',
    'phone',
    'password',
    'role',     
    'status',   
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

public function isAdmin() {
    return $this->role === 'admin';
}
public function isDoctor() {
    return $this->role === 'doctor';
}
public function isPatient() {
    return $this->role === 'patient';
}



public function doctor()
{
    return $this->hasOne(\App\Models\Doctor::class);
}


public function notifications()
{
    return $this->hasMany(Notification::class);
}


// public function appointmentsAsPatient()
// {
//     return $this->hasMany(App\Models\Appointment::class, 'patient_id');
// }

// If patient:
public function appointmentsAsPatient()
{
    return $this->hasMany(\App\Models\Appointment::class, 'patient_id');
}

// If doctor:
public function appointmentsAsDoctor()
{
    return $this->hasMany(\App\Models\Appointment::class, 'doctor_id');
}



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
