<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'time_slot',
    ];

    /**
     * Relationship: Availability belongs to a Doctor
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
