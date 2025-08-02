<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalTimeSlot extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'slot_duration',
        'days',
    ];

    protected $casts = [
        'days' => 'array',
    ];
}
