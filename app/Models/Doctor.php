<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization_id',
        'bio',
    ];

    /**
     * Relationship: Doctor belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Doctor belongs to a Specialization
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }


    
    /**
     * Relationship: Doctor has many appointments
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
