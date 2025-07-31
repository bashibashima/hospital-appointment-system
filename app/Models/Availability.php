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
        'start_time',
        'end_time',
    ];

    /**
     * Relationship: Availability belongs to a Doctor
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
